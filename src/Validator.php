<?php

namespace Kontrolio;

use Kontrolio\Data\Attribute;
use Kontrolio\Data\Data;
use Kontrolio\Error\Errors;
use Kontrolio\Rules\Core\Sometimes;
use Kontrolio\Rules\Core\UntilFirstFailure;
use Kontrolio\Rules\ArrayNormalizer;
use Kontrolio\Rules\Instantiator;
use Kontrolio\Rules\StopsFurtherValidationInterface;
use Kontrolio\Rules\Parser;
use Kontrolio\Rules\Repository;
use Kontrolio\Rules\CallableRuleWrapper;
use Kontrolio\Rules\RuleInterface;
use UnexpectedValueException;

/**
 * Main class of the validation service.
 *
 * @package Kontrolio
 */
class Validator implements ValidatorInterface
{
    /**
     * Data to validate.
     *
     * @var Data
     */
    protected $data;
    
    /**
     * Raw validation rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Formatted validation rules.
     *
     * @var array
     */
    protected $normalizedRules = [];

    /**
     * Validation messages.
     *
     * @var array
     */
    protected $messages = [];

    private $repository;
    private $normalizer;

    /**
     * Validation errors.
     *
     * @var Errors
     */
    protected $errors;

    /**
     * Flag indicating that the validation should stop.
     *
     * @var bool
     */
    protected $shouldStopOnFirstFailure = false;

    /**
     * Flag indication that the validation of the current attribute should stop.
     *
     * @var bool
     */
    protected $shouldStopWithinAttribute = false;

    /**
     * Flag indicating that the validation can be bypassed.
     *
     * @var bool
     */
    private $bypass = false;

    /**
     * Validator constructor.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     */
    public function __construct(array $data, array $rules, array $messages = [])
    {
        $this->data = new Data($data);
        $this->rules = $rules;
        $this->messages = $messages;
        $instantiator = new Instantiator();
        $this->repository = new Repository($instantiator);
        $this->normalizer = new ArrayNormalizer(new Parser($this->repository));
        $this->errors = new Errors($messages);
    }

    /**
     * Extends available rules with new ones.
     *
     * @param array $rules
     *
     * @return $this
     */
    public function extend(array $rules)
    {
        $this->repository->add($rules);

        return $this;
    }

    /**
     * Returns all available validation rules.
     *
     * @return array
     */
    public function getAvailable()
    {
        return $this->repository->all();
    }

    /**
     * Returns data that's being validated.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data->raw();
    }

    /**
     * Sets data that need to be validated.
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = new Data($data);

        return $this;
    }

    /**
     * Returns validation rules.
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Checks proper format of the validation rules and sets them for the validator.
     *
     * @param array $rules
     *
     * @return $this
     * @throws UnexpectedValueException
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
        $this->normalizedRules = $this->normalizer->normalize($rules);

        return $this;
    }

    /**
     * Returns validation messages.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Sets validation messages.
     *
     * @param array $messages
     *
     * @return $this
     */
    public function setMessages(array $messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Validates given data.
     *
     * @return bool
     * @throws UnexpectedValueException
     */
    public function validate()
    {
        if (empty($this->normalizedRules)) {
            $this->normalizedRules = $this->normalizer->normalize($this->rules);
        }

        foreach ($this->normalizedRules as $attrName => $rules) {
            $this->bypass = false;
            $this->shouldStopWithinAttribute = false;

            foreach ($rules as $rule) {
                if ($rule instanceof UntilFirstFailure) {
                    $this->shouldStopWithinAttribute = true;
                }

                $attribute = $this->data->get($attrName);
                $rule = $this->resolveRule($rule, $attribute);

                $this->handle($rule, $attribute);

                if ($this->shouldProceedToTheNextAttribute($attrName)) {
                    continue 2;
                }
                
                if ($this->shouldStopOnFailure($rule, $attrName)) {
                    return false;
                }
            }
        }
        
        return $this->errors->isEmpty();
    }

    /**
     * Processes a data attribute and creates new validation error message if the validation failed.
     *
     * @param RuleInterface $rule
     * @param Attribute $attribute
     * @throws UnexpectedValueException
     */
    protected function handle($rule, Attribute $attribute)
    {
        if ($rule instanceof Sometimes && $attribute->isEmpty()) {
            $this->bypass = true;

            return;
        }

        $raw = $attribute->getValue();

        if ($rule->isValid($raw) ||
            $rule->canSkipValidation($raw) ||
            ($rule->emptyValueAllowed() && $attribute->isEmpty())) {
            return;
        }

        $this->errors->add($attribute, $rule);
    }

    /**
     * Resolves validation rule according to actual rule type.
     *
     * @param callable|RuleInterface $rule
     * @param mixed $value
     *
     * @return RuleInterface
     * @throws UnexpectedValueException
     */
    protected function resolveRule($rule, Attribute $value)
    {
        if ($rule instanceof RuleInterface) {
            return $rule;
        }
        
        if (is_callable($rule)) {
            return new CallableRuleWrapper($rule($value->getValue()));
        }

        throw new UnexpectedValueException(sprintf('Rule must implement `%s` or be callable.', RuleInterface::class));
    }

    /**
     * Determines whether validation should stop on the first failure.
     *
     * @param string $attribute
     * @param RuleInterface $rule
     *
     * @return bool
     */
    protected function shouldStopOnFailure(RuleInterface $rule, $attribute)
    {
        return (
            $rule instanceof StopsFurtherValidationInterface ||
            $this->shouldStopOnFirstFailure ||
            $this->shouldStopWithinAttribute
        ) && $this->errors->has($attribute);
    }

    /**
     * Determines whether validator should proceed to the next attribute
     *
     * @param string $attribute
     *
     * @return bool
     */
    protected function shouldProceedToTheNextAttribute($attribute)
    {
        return $this->bypass || ($this->shouldStopWithinAttribute && $this->errors->has($attribute));
    }

    /**
     * Checks whether there are validation errors.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return !$this->errors->isEmpty();
    }

    /**
     * Returns all validation errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors->raw();
    }

    /**
     * Returns a plain validation errors array without their attribute names.
     *
     * @return array
     */
    public function getErrorsList()
    {
        return $this->errors->flatten();
    }

    /**
     * Determines whether validation should stop on the first failure.
     *
     * @param bool $stop
     *
     * @return $this
     */
    public function shouldStopOnFirstFailure($stop = true)
    {
        $this->shouldStopOnFirstFailure = $stop;

        return $this;
    }
}
