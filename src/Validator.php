<?php
declare(strict_types=1);

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
    private Data $data;

    /**
     * Formatted validation rules.
     *
     * @var array
     */
    private array $normalizedRules = [];

    /**
     * Available validation rules.
     *
     * @var Repository
     */
    private Repository $repository;

    /**
     * Raw rules normalizer.
     *
     * @var ArrayNormalizer
     */
    private ArrayNormalizer $normalizer;

    /**
     * Validation errors.
     *
     * @var Errors
     */
    private Errors $errors;

    /**
     * Flag indicating that the validation should stop.
     *
     * @var bool
     */
    private bool $shouldStopOnFirstFailure = false;

    /**
     * Validator constructor.
     *
     * @param array $data Data to validate
     * @param array $rules Validation rules
     * @param array $messages Validation messages
     */
    public function __construct(
        array $data,
        private array $rules,
        private array $messages = [])
    {
        $this->data = new Data($data);
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
    public function extend(array $rules): static
    {
        $this->repository->add($rules);

        return $this;
    }

    /**
     * Returns all available validation rules.
     *
     * @return array
     */
    public function getAvailable(): array
    {
        return $this->repository->all();
    }

    /**
     * Returns data that's being validated.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data->raw;
    }

    /**
     * Sets data that need to be validated.
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data): static
    {
        $this->data = new Data($data);

        return $this;
    }

    /**
     * Returns validation rules.
     *
     * @return array
     */
    public function getRules(): array
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
    public function setRules(array $rules): static
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
    public function getMessages(): array
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
    public function setMessages(array $messages): static
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
    public function validate(): bool
    {
        if (empty($this->normalizedRules)) {
            $this->normalizedRules = $this->normalizer->normalize($this->rules);
        }

        $untilFirstFailure = false;

        foreach ($this->normalizedRules as $attrName => $rules) {
            foreach ($rules as $rule) {
                $attribute = $this->data->get($attrName);
                $rule = is_callable($rule)
                    ? new CallableRuleWrapper($rule, $attribute->value)
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
    public function hasErrors(): bool
    {
        return !$this->errors->isEmpty();
    }

    /**
     * Returns all validation errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors->raw();
    }

    /**
     * Returns a plain validation errors array without their attribute names.
     *
     * @return array
     */
    public function getErrorsList(): array
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
    public function shouldStopOnFirstFailure(bool $stop = true): static
    {
        $this->shouldStopOnFirstFailure = $stop;

        return $this;
    }
}
