<?php

namespace Kontrolio;

use Kontrolio\Data\Data;
use Kontrolio\Error\Errors;
use Kontrolio\Rules\Core\UntilFirstFailure;
use Kontrolio\Rules\ArrayNormalizer;
use Kontrolio\Rules\Instantiator;
use Kontrolio\Rules\StopsFurtherValidationInterface;
use Kontrolio\Rules\Parser;
use Kontrolio\Rules\Repository;
use Kontrolio\Rules\CallableRuleWrapper;
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
    private $data;
    
    /**
     * Raw validation rules.
     *
     * @var array
     */
    private $rules;

    /**
     * Formatted validation rules.
     *
     * @var array
     */
    private $normalizedRules = [];

    /**
     * Validation messages.
     *
     * @var array
     */
    private $messages;

    /**
     * Available validation rules.
     *
     * @var Repository
     */
    private $repository;

    /**
     * Raw rules normalizer.
     *
     * @var ArrayNormalizer
     */
    private $normalizer;

    /**
     * Validation errors.
     *
     * @var Errors
     */
    private $errors;

    /**
     * Flag indicating that the validation should stop.
     *
     * @var bool
     */
    private $shouldStopOnFirstFailure = false;

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

        $untilFirstFailure = false;

        foreach ($this->normalizedRules as $attrName => $rules) {
            foreach ($rules as $rule) {
                $attribute = $this->data->get($attrName);
                $rule = is_callable($rule)
                    ? new CallableRuleWrapper($rule, $attribute->getValue())
                    : $rule;

                if ($rule instanceof UntilFirstFailure) {
                    $untilFirstFailure = true;
                }

                if ($attribute->canSkip($rule)) {
                    continue 2;
                }

                if ($attribute->conformsTo($rule)) {
                    continue;
                }

                $this->errors->add($attribute, $rule);

                if ($rule instanceof StopsFurtherValidationInterface ||
                    $this->shouldStopOnFirstFailure) {
                    return false;
                }

                if ($untilFirstFailure) {
                    continue 2;
                }
            }
        }
        
        return $this->errors->isEmpty();
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
