<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

class Ip extends AbstractRule
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

    /**
     * IP version flag.
     *
     * @var int
     */
    protected $version;

    /**
     * Ip constructor.
     *
     * @param string $version
     */
    public function __construct($version = self::V4)
    {
        $this->version = $version;
    }

    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid($input = null)
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
    protected function getFlag()
    {
        switch ($this->version) {
            case static::V4:
                return FILTER_FLAG_IPV4;
            case static::V6:
                return FILTER_FLAG_IPV6;
            case static::V4_NO_PRIV:
                return FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE;
            case static::V6_NO_PRIV:
                return FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE;
            case static::ALL_NO_PRIV:
                return FILTER_FLAG_NO_PRIV_RANGE;
            case static::V4_NO_RES:
                return FILTER_FLAG_IPV4 | FILTER_FLAG_NO_RES_RANGE;
            case static::V6_NO_RES:
                return FILTER_FLAG_IPV6 | FILTER_FLAG_NO_RES_RANGE;
            case static::ALL_NO_RES:
                return FILTER_FLAG_NO_RES_RANGE;
            case static::V4_ONLY_PUBLIC:
                return FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE;
            case static::V6_ONLY_PUBLIC:
                return FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE;
            case static::ALL_ONLY_PUBLIC:
                return FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE;
            default:
                return null;
        }
    }
}