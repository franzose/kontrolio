<?php
declare(strict_types=1);

namespace Kontrolio;

/**
 * Interface for validation factory aware services.
 *
 * @package Kontrolio
 */
interface FactoryAwareInterface
{
    /**
     * Returns validation factory instance.
     *
     * @return FactoryInterface
     */
    public function getValidationFactory(): FactoryInterface;

    /**
     * Sets validation factory instance.
     *
     * @param FactoryInterface $factory
     *
     * @return $this
     */
    public function setValidationFactory(FactoryInterface $factory): static;

    /**
     * Builds validator using validation factory.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     *
     * @return ValidatorInterface
     */
    public function makeValidator(array $data, array $rules, array $messages = []): ValidatorInterface;
}
