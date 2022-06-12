<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

enum IpAddressVersion
{
    case V4;
    case V6;
    case All;
    case V4NoPrivateRanges;
    case V6NoPrivateRanges;
    case AllNoPrivateRanges;
    case V4NoReservedRanges;
    case V6NoReservedRanges;
    case AllNoReservedRanges;
    case V4OnlyPublic;
    case V6OnlyPublic;
    case AllOnlyPublic;
}
