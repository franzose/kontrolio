<?php
declare(strict_types=1);

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
    public function extend(array $rules): static;

    /**
     * Returns data that's being validated.
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Sets data that need to be validated.
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data): static;

    /**
     * Returns validation rules.
     *
     * @return array
     */
    public function getRules(): array;

    /**
     * Checks proper format of the validation rules and sets them for the validator.
     *
     * @param array $rules
     *
     * @return $this
     * @throws \OutOfBoundsException
     * @throws \UnexpectedValueException
     */
    public function setRules(array $rules): static;

    /**
     * Returns validation messages.
     *
     * @return array
     */
    public function getMessages(): array;

    /**
     * Sets validation messages.
     *
     * @param array $messages
     *
     * @return $this
     */
    public function setMessages(array $messages): static;

    /**
     * Validates given data.
     *
     * @return bool
     * @throws \UnexpectedValueException
     */
    public function validate(): bool;

    /**
     * Checks whether there are validation errors.
     *
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * Returns all validation errors.
     *
     * @return array
     */
    public function getErrors(): array;

    /**
     * Returns a plain validation errors array without their attribute names.
     *
     * @return array
     */
    public function getErrorsList(): array;

    /**
     * Determines whether validation should stop on the first failure.
     *
     * @param bool $stop
     *
     * @return $this
     */
    public function shouldStopOnFirstFailure(bool $stop = true): static;
}
