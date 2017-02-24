<?php

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
    protected $validationFactory;

    /**
     * Returns validation factory instance.
     *
     * @return FactoryInterface
     */
    public function getValidationFactory()
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
    public function setValidationFactory(FactoryInterface $factory)
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
    public function makeValidator(array $data, array $rules, array $messages = [])
    {
        return $this->validationFactory->make($data, $rules, $messages);
    }
}
