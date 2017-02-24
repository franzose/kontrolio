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

    /**
     * Extends available rules with new ones.
     *
     * @param array $rules
     *
     * @return $this
     */
    public function extend(array $rules);

    /**
     * Returns all available validation rules.
     *
     * @return array
     */
    public function getAvailable();
}
