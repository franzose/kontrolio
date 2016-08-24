<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Class IsIn
 * @package Kontrolio\Rules\Core
 * @author maximkou <maximkou@gmail.com>
 */
class IsIn extends AbstractRule
{

    /**
     * @var bool
     */
    protected $strictCompare;

    /**
     * @var array
     */
    protected $haystack;

    /**
     * IsIn constructor.
     * @param array $haystack
     * @param bool $strictCompare
     */
    public function __construct(array $haystack = [], $strictCompare = true)
    {
        $this->haystack = $haystack;
        $this->strictCompare = $strictCompare;
    }

    /**
     * @inheritdoc
     */
    public function isValid($input = null)
    {
        return in_array($input, $this->haystack, $this->strictCompare);
    }
}
