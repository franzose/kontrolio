<?php

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
    public function getName();

    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid($input = null);

    /**
     * When true, validation will be skipped if validated value is null or an empty string.
     *
     * @return bool
     */
    public function emptyValueAllowed();

    /**
     * Allows skipping validation when value is null or an empty string.
     *
     * @return $this
     */
    public function allowEmptyValue();

    /**
     * When simply true or some conditions return true, informs validator service that validation can be skipped.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function canSkipValidation($input = null);

    /**
     * Checks whether validation rule has any violations.
     *
     * @return bool
     */
    public function hasViolations();

    /**
     * Returns validation rule violations.
     *
     * @return array
     */
    public function getViolations();
}
