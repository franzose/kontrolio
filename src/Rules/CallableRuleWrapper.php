<?php

namespace Kontrolio\Rules;

use UnexpectedValueException;

/**
 * Wrapper for callback validation rules.
 *
 * @package Kontrolio\Rules
 */
class CallableRuleWrapper extends AbstractRule
{
    /**
     * Validation rule identifier.
     *
     * @var string
     */
    private $name;

    /**
     * Valid/invalid state.
     *
     * @var bool
     */
    private $valid = false;

    /**
     * Skipping state.
     *
     * @var bool
     */
    private $skip = false;

    /**
     * Validation rule constructor.
     *
     * @param bool|array $result Result returned by a callback validation rule
     * @throws UnexpectedValueException
     */
    public function __construct($result)
    {
        is_bool($result) ? $this->setDefaults($result)
                         : $this->setDefaultsFromArray($result);
    }

    /**
     * Sets default values for wrapper's properties.
     *
     * @param bool $result
     */
    private function setDefaults($result)
    {
        $this->valid = $result;
        $this->emptyAllowed = false;
        $this->skip = false;
    }

    /**
     * Sets properties coming from resulting array of the callback validation rule.
     *
     * @param array $attributes
     * @throws UnexpectedValueException
     */
    private function setDefaultsFromArray(array $attributes)
    {
        if (!isset($attributes['valid'])) {
            throw new UnexpectedValueException('Validation check missing.');
        }

        if (isset($attributes['name'])) {
            $this->name = $attributes['name'];
        }

        $this->valid = (bool) $attributes['valid'];
        $this->emptyAllowed = isset($attributes['empty_allowed'])
            ? (bool) $attributes['empty_allowed']
            : false;

        $this->skip = isset($attributes['skip']) ? (bool) $attributes['skip'] : false;
        $this->violations = isset($attributes['violations']) ? $attributes['violations'] : [];
    }

    /**
     * Returns validation rule identifier.
     *
     * @return string
     */
    public function getName()
    {
        if (isset($this->name)) {
            return $this->name;
        }

        return uniqid(parent::getName() . '_', true);
    }

    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid($input = null)
    {
        return $this->valid;
    }

    /**
     * When simply true or some conditions return true, informs validator service that validation can be skipped.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function canSkipValidation($input = null)
    {
        return $this->skip;
    }
}
