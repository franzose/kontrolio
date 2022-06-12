<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * IP address validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
final class IpAddress extends AbstractRule
{
    const V4 = '4';
    const V6 = '6';
    const ALL = 'all';

    // adds FILTER_FLAG_NO_PRIV_RANGE flag (skip private ranges)
    const V4_NO_PRIV = '4_no_priv';
    const V6_NO_PRIV = '6_no_priv';
    const ALL_NO_PRIV = 'all_no_priv';

    // adds FILTER_FLAG_NO_RES_RANGE flag (skip reserved ranges)
    const V4_NO_RES = '4_no_res';
    const V6_NO_RES = '6_no_res';
    const ALL_NO_RES = 'all_no_res';

    // adds FILTER_FLAG_NO_PRIV_RANGE and FILTER_FLAG_NO_RES_RANGE flags (skip both)
    const V4_ONLY_PUBLIC = '4_public';
    const V6_ONLY_PUBLIC = '6_public';
    const ALL_ONLY_PUBLIC = 'all_public';

    public function __construct(private readonly string $version = self::V4)
    {
    }

    public function isValid(mixed $input = null): bool
    {
        if ($input === null || $input === '') {
            return false;
        }

        $input = (string) $input;

        if (!filter_var($input, FILTER_VALIDATE_IP, $this->getFlag())) {
            return false;
        }

        return true;
    }

    /**
     * Returns IP filter flag.
     *
     * @return int|null
     */
    protected function getFlag(): ?int
    {
        return match ($this->version) {
            static::V4 => FILTER_FLAG_IPV4,
            static::V6 => FILTER_FLAG_IPV6,
            static::V4_NO_PRIV => FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE,
            static::V6_NO_PRIV => FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE,
            static::ALL_NO_PRIV => FILTER_FLAG_NO_PRIV_RANGE,
            static::V4_NO_RES => FILTER_FLAG_IPV4 | FILTER_FLAG_NO_RES_RANGE,
            static::V6_NO_RES => FILTER_FLAG_IPV6 | FILTER_FLAG_NO_RES_RANGE,
            static::ALL_NO_RES => FILTER_FLAG_NO_RES_RANGE,
            static::V4_ONLY_PUBLIC => FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
            static::V6_ONLY_PUBLIC => FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
            static::ALL_ONLY_PUBLIC => FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
            default => null,
        };
    }
}
