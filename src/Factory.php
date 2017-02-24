<?php

namespace Kontrolio;

/**
 * Validation service factory.
 *
 * @package Kontrolio
 */
class Factory implements FactoryInterface
{
    /**
     * Cached instance of the validation factory.
     *
     * @var static
     */
    private static $instance;

    /**
     * All available validation rules.
     *
     * @var array
     */
    protected $available = [];

    /**
     * Validation service factory constructor.
     */
    public function __construct()
    {
        $this->extend(require __DIR__ . '/../config/aliases.php');
    }

    /**
     * Returns singleton instance of the validation factory.
     * It's supposed to use only in container unaware environments.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            return static::$instance = new static;
        }

        return static::$instance;
    }

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
        return (new Validator($data, $rules, $messages))->extend($this->available);
    }

    /**
     * Extends available rules with new ones.
     *
     * @param array $rules
     *
     * @return $this
     */
    public function extend(array $rules)
    {
        $this->available = array_merge($this->available, $rules);

        return $this;
    }

    /**
     * Returns all available validation rules.
     *
     * @return array
     */
    public function getAvailable()
    {
        return $this->available;
    }
}
