<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Email validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
final class Email extends AbstractRule
{
    /**
     * Email validation rule constructor.
     *
     * @param bool $mx Whether to check MX record
     * @param bool $host Whether to check host
     */
    public function __construct(
        private readonly bool $mx = false,
        private readonly bool $host = false
    ) {
    }

    public function isValid(mixed $input = null): bool
    {
        if (!preg_match('/^.+\@\S+\.\S+$/', $input)) {
            return false;
        }

        $host = substr($input, strrpos($input, '@') + 1);

        if ($this->mx && !$this->checkMX($host)) {
            $this->violations[] = 'mx';
        }

        if ($this->host && !$this->checkHost($host)) {
            $this->violations[] = 'host';
        }

        return !$this->hasViolations();
    }

    /**
     * Checks DNS records for MX type.
     *
     * @param string $host
     *
     * @return bool
     */
    private function checkMX(string $host): bool
    {
        return checkdnsrr($host);
    }

    /**
     * Check if one of MX, A or AAAA DNS RR exists.
     *
     * @param string $host
     *
     * @return bool
     */
    private function checkHost(string $host): bool
    {
        return $this->checkMX($host) || (checkdnsrr($host, 'A') || checkdnsrr($host, 'AAAA'));
    }
}
