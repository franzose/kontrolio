<?php
declare(strict_types=1);

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
     * Original rule.
     *
     * @var callable
     */
    private $rule;

    /**
     * Value that must be validated.
     *
     * @var mixed
     */
    private mixed $value;

    /**
     * Validation rule identifier.
     *
     * @var string
     */
    private string $name;

    /**
     * Valid/invalid state.
     *
     * @var bool
     */
    private bool $valid = false;

    /**
     * Skipping state.
     *
     * @var bool
     */
    private bool $skip = false;

    public function __construct(callable|array $rule, mixed $value = null)
    {
        is_array($rule)
            ? $this->setDefaultsFromArray($rule)
            : $this->setDefaults($rule, $value);
    }

    /**
     * Sets default values for wrapper's properties.
     *
     * @param callable $rule
     * @param mixed $value
     */
    private function setDefaults(callable $rule, mixed $value): void
    {
        $this->rule = $rule;
        $this->value = $value;
        $this->emptyAllowed = false;
        $this->skip = false;
    }

    /**
     * Sets properties coming from resulting array of the callback validation rule.
     *
     * @param array $attributes
     * @throws UnexpectedValueException
     */
    private function setDefaultsFromArray(array $attributes): void
    {
        if (!isset($attributes['valid'])) {
            throw new UnexpectedValueException('Validation check missing.');
        }

        if (isset($attributes['name'])) {
            $this->name = $attributes['name'];
        }

        $this->valid = (bool) $attributes['valid'];
        $this->emptyAllowed = isset($attributes['empty_allowed']) && (bool)$attributes['empty_allowed'];

        $this->skip = isset($attributes['skip']) && (bool)$attributes['skip'];
        $this->violations = $attributes['violations'] ?? [];
    }

    /**
     * Returns validation rule identifier.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name ?? uniqid(parent::getName() . '_', true);
    }

    public function isValid(mixed $input = null): bool
    {
        $rule = $this->rule;

        return is_callable($rule) ? $rule($this->value) : $this->valid;
    }

    /**
     * When simply true or some conditions return true, informs validator service that validation can be skipped.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function canSkipValidation(mixed $input = null): bool
    {
        return $this->skip;
    }
}
