<?php

namespace Kontrolio;

/**
 * Interface for validation service factories.
 *
 * @package Kontrolio
 */
interface FactoryInterface
{
    /**
     * Creates new validator instance.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     *
     * @return ValidatorInterface
     */
    public function make(array $data, array $rules, array $messages = []);
}