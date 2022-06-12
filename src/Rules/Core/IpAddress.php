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
    public function __construct(private readonly IpAddressVersion $version = IpAddressVersion::V4)
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
            IpAddressVersion::V4 => FILTER_FLAG_IPV4,
            IpAddressVersion::V6 => FILTER_FLAG_IPV6,
            IpAddressVersion::V4NoPrivateRanges => FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE,
            IpAddressVersion::V6NoPrivateRanges => FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE,
            IpAddressVersion::AllNoPrivateRanges => FILTER_FLAG_NO_PRIV_RANGE,
            IpAddressVersion::V4NoReservedRanges => FILTER_FLAG_IPV4 | FILTER_FLAG_NO_RES_RANGE,
            IpAddressVersion::V6NoReservedRanges => FILTER_FLAG_IPV6 | FILTER_FLAG_NO_RES_RANGE,
            IpAddressVersion::AllNoReservedRanges => FILTER_FLAG_NO_RES_RANGE,
            IpAddressVersion::V4OnlyPublic => FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
            IpAddressVersion::V6OnlyPublic => FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
            IpAddressVersion::AllOnlyPublic => FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
            default => null,
        };
    }
}
