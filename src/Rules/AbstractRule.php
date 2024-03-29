<?php
declare(strict_types=1);

namespace Kontrolio\Rules;

/**
 * Validation rule base class.
 *
 * @package Kontrolio\Rules
 */
abstract class AbstractRule implements RuleInterface
{
    /**
     * Empty allowed/disallowed state.
     *
     * @var bool
     */
    protected bool $emptyAllowed = false;

    /**
     * Validation violations.
     *
     * @var array
     */
    protected array $violations = [];

    /**
     * Constructs a rule allowing empty input by default.
     *
     * @return $this
     */
    public static function allowingEmptyValue(): static
    {
        return (new static())->allowEmptyValue();
    }

    /**
     * Returns validation rule identifier.
     *
     * @return string
     */
    public function getName(): string
    {
        $class = get_class($this);
        $segments = explode('\\', $class);
        $name = end($segments);

        if (!ctype_lower($name)) {
            $name = preg_replace('/\s+/u', '', $name);
            $name = mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1_', $name), 'UTF-8');
        }

        $postfix = strrpos($name, '_rule');

        if ($postfix !== false) {
            $name = substr($name, 0, $postfix);
        }

        return $name;
    }

    /**
     * When true, validation will be bypassed if validated value is null or an empty string.
     *
     * @return bool
     */
    public function emptyValueAllowed(): bool
    {
        return $this->emptyAllowed;
    }

    /**
     * Allows bypassing validation when value is null or an empty string.
     *
     * @return $this
     */
    public function allowEmptyValue(): static
    {
        $this->emptyAllowed = true;
        
        return $this;
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
        return false;
    }

    /**
     * Checks whether validation rule has any violations.
     *
     * @return bool
     */
    public function hasViolations(): bool
    {
        return count($this->violations) > 0;
    }

    /**
     * Returns validation rule violations.
     *
     * @return array
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
