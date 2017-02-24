<?php

namespace Kontrolio;

/**
 * Trait to provide validation service.
 *
 * @package Kontrolio
 */
trait ValidatorAwareTrait
{
    /**
     * Validator instance.
     *
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * Sets validator.
     *
     * @param ValidatorInterface $validator
     *
     * @return $this
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Performs validation.
     *
     * @return bool
     */
    public function validate()
    {
        return $this->validator->validate();
    }
}
