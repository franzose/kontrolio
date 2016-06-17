<?php

namespace Kontrolio;

/**
 * Validation service factory.
 *
 * @package Kontrolio
 */
final class Factory implements FactoryInterface
{
    /**
     * Creates new validator instance.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     *
     * @return Validator
     */
    public function make(array $data, array $rules, array $messages = [])
    {
        return new Validator($data, $rules, $messages);
    }
}