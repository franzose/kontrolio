<?php
declare(strict_types=1);

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
    protected ValidatorInterface $validator;

    /**
     * Sets validator.
     *
     * @param ValidatorInterface $validator
     *
     * @return $this
     */
    public function setValidator(ValidatorInterface $validator): static
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Performs validation.
     *
     * @return bool
     */
    public function validate(): bool
    {
        return $this->validator->validate();
    }
}
