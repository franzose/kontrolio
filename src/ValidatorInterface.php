<?php

namespace Kontrolio;

/**
 * Base interface for the validator service.
 *
 * @package Kontrolio\Rules
 */
interface ValidatorInterface
{
    /**
     * Returns data that's being validated.
     *
     * @return array
     */
    public function getData();

    /**
     * Returns validation rules.
     *
     * @return array
     */
    public function getRules();

    /**
     * Checks proper format of the validation rules and sets them for the validator.
     *
     * @param array $rules
     *
     * @return $this
     * @throws \OutOfBoundsException
     * @throws \UnexpectedValueException
     */
    public function setRules(array $rules);

    /**
     * Returns validation messages.
     *
     * @return array
     */
    public function getMessages();

    /**
     * Validates given data.
     *
     * @return bool
     * @throws \UnexpectedValueException
     */
    public function validate();

    /**
     * Checks whether there are validation errors.
     *
     * @return bool
     */
    public function hasErrors();

    /**
     * Returns all validation errors.
     *
     * @return array
     */
    public function getErrors();

    /**
     * Determines whether validation should stop on the first failure.
     *
     * @param bool $stop
     * 
     * @return $this
     */
    public function shouldStopOnFirstFailure($stop = true);
}