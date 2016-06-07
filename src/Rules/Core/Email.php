<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Email validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class Email extends AbstractRule
{
    /**
     * Whether to check MX record.
     *
     * @var bool
     */
    private $mx;

    /**
     * Whether to check host.
     *
     * @var bool
     */
    private $host;

    /**
     * Email validation rule constructor.
     *
     * @param bool $mx
     * @param bool $host
     */
    public function __construct($mx = false, $host = false)
    {
        $this->mx = $mx;
        $this->host = $host;
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
    private function checkMX($host)
    {
        return checkdnsrr($host, 'MX');
    }

    /**
     * Check if one of MX, A or AAAA DNS RR exists.
     *
     * @param string $host
     *
     * @return bool
     */
    private function checkHost($host)
    {
        return $this->checkMX($host) || (checkdnsrr($host, 'A') || checkdnsrr($host, 'AAAA'));
    }
}