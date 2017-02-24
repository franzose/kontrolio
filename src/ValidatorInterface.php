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
     * Extends available rules with new ones.
     *
     * @param array $rules
     *
     * @return $this
     */
    public function extend(array $rules);

    /**
     * Returns data that's being validated.
     *
     * @return array
     */
    public function getData();

    /**
     * Sets data that need to be validated.
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data);

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
     * Sets validation messages.
     *
     * @param array $messages
     *
     * @return $this
     */
    public function setMessages(array $messages);

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
     * Returns a plain validation errors array without their attribute names.
     *
     * @return array
     */
    public function getErrorsList();

    /**
     * Determines whether validation should stop on the first failure.
     *
     * @param bool $stop
     *
     * @return $this
     */
    public function shouldStopOnFirstFailure($stop = true);
}
