<?php
declare(strict_types=1);

namespace Kontrolio\Rules;

/**
 * Base interface for validation rules.
 *
 * @package Kontrolio\Rules
 */
interface RuleInterface
{
    /**
     * Returns validation rule identifier.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid(mixed $input = null): bool;

    /**
     * When true, validation will be skipped if validated value is null or an empty string.
     *
     * @return bool
     */
    public function emptyValueAllowed(): bool;

    /**
     * Allows skipping validation when value is null or an empty string.
     *
     * @return $this
     */
    public function allowEmptyValue(): static;

    /**
     * When simply true or some conditions return true, informs validator service that validation can be skipped.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function canSkipValidation(mixed $input = null): bool;

    /**
     * Checks whether validation rule has any violations.
     *
     * @return bool
     */
    public function hasViolations(): bool;

    /**
     * Returns validation rule violations.
     *
     * @return array
     */
    public function getViolations(): array;
}
