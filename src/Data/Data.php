<?php
declare(strict_types=1);

namespace Kontrolio\Data;

/**
 * Validated data.
 */
final class Data
{
    public function __construct(public readonly array $raw)
    {
    }

    /**
     * Returns an object representation of the given attribute.
     *
     * @param string|null $attribute
     *
     * @return Attribute
     */
    public function get(?string $attribute): Attribute
    {
        $attribute ??= '';

        if (isset($this->raw[$attribute])) {
            return new Attribute($attribute, $this->raw[$attribute]);
        }

        $segments = explode('.', $attribute);
        $data = null;

        foreach ($segments as $segment) {
            if (!array_key_exists($segment, $this->raw)) {
                return new Attribute($attribute);
            }

            $data = $this->raw[$segment];
        }

        return new Attribute($attribute, $data);
    }
}
