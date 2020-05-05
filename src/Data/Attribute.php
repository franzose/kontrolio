<?php

namespace Kontrolio\Data;

final class Attribute
{
    private $value;
    private $attribute;

    /**
     * @param string $attribute
     * @param mixed $value
     */
    public function __construct($attribute, $value = null)
    {
        $this->attribute = $attribute;
        $this->value = $value;
    }

    public function getName()
    {
        return $this->attribute;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function isEmpty()
    {
        return $this->value === null || $this->value === '';
    }
}
