<?php
declare(strict_types=1);

namespace Kontrolio;

/**
 * Validation factory helper trait.
 *
 * @package Kontrolio
 */
trait FactoryAwareTrait
{
    /**
     * Validation factory instance.
     *
     * @var FactoryInterface
     */
    protected FactoryInterface $validationFactory;

    /**
     * Returns validation factory instance.
     *
     * @return FactoryInterface
     */
    public function getValidationFactory(): FactoryInterface
    {
        return $this->validationFactory;
    }

    /**
     * Sets validation factory instance.
     *
     * @param FactoryInterface $factory
     *
     * @return $this
     */
    public function setValidationFactory(FactoryInterface $factory): static
    {
        $this->validationFactory = $factory;

        return $this;
    }

    /**
     * Builds validator using validation factory.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     *
     * @return ValidatorInterface
     */
    public function makeValidator(array $data, array $rules, array $messages = []): ValidatorInterface
    {
        return $this->validationFactory->make($data, $rules, $messages);
    }
}
