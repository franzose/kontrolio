<?php
declare(strict_types=1);

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
    private static self $instance;

    /**
     * All available validation rules.
     *
     * @var array
     */
    protected array $available = [];

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
    public static function getInstance(): static
    {
        return static::$instance ?? (static::$instance = new static);
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
    public function make(array $data, array $rules, array $messages = []): ValidatorInterface
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
    public function extend(array $rules): static
    {
        $this->available = array_merge($this->available, $rules);

        return $this;
    }

    /**
     * Returns all available validation rules.
     *
     * @return array
     */
    public function getAvailable(): array
    {
        return $this->available;
    }
}
