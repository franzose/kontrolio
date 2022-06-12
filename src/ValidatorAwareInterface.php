<?php
declare(strict_types=1);

namespace Kontrolio;

/**
 * Base interface to provide validation service.
 *
 * @package Kontrolio
 */
interface ValidatorAwareInterface
{
    /**
     * Sets validator.
     *
     * @param ValidatorInterface $validator
     *
     * @return $this
     */
    public function setValidator(ValidatorInterface $validator);

    /**
     * Performs validation.
     *
     * @return bool
     */
    public function validate();
}
