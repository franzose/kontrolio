<?php

namespace Kontrolio\Data;

/**
 * Validated data.
 */
final class Data
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function raw()
    {
        return $this->data;
    }

    /**
     * Returns an object representation of the given attribute.
     *
     * @param string $attribute
     *
     * @return Attribute
     */
    public function get($attribute)
    {
        if ($attribute === null) {
            return new Attribute($attribute);
        }

        if (isset($this->data[$attribute])) {
            return new Attribute($attribute, $this->data[$attribute]);
        }

        $segments = explode('.', $attribute);
        $data = null;

        foreach ($segments as $segment) {
            if (!array_key_exists($segment, $this->data)) {
                return new Attribute($attribute);
            }

            $data = $this->data[$segment];
        }

        return new Attribute($attribute, $data);
    }
}
