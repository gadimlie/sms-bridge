<?php

namespace Gadimlie\SmsBridge\Helpers;

class PhoneValidator
{
    /**
     * Validates and formats Azerbaijani mobile numbers.
     *
     * @param string $msisdn
     * @return string|false Returns formatted number or false if invalid.
     */
    public static function formatLocalNumber(string $msisdn): string|false
    {
        $msisdn = preg_replace('/[\s\-]+/', '', $msisdn);

        if (strlen($msisdn) < 9) {
            return false;
        }

        // Normalize to full international format if it starts with 0 or +994
        if (str_starts_with($msisdn, '+994')) {
            $msisdn = substr($msisdn, 1); // remove +
        } elseif (str_starts_with($msisdn, '0')) {
            $msisdn = '994' . substr($msisdn, 1); // strip 0
        }

        // Now it should start with 994 and be 12 digits
        if (!str_starts_with($msisdn, '994') || strlen($msisdn) !== 12) {
            return false;
        }

        // Check valid operator codes
        $prefix = substr($msisdn, 3, 2); // extract operator prefix
        $validPrefixes = ['10', '50', '51', '55', '60', '70', '77', '99'];

        if (!in_array($prefix, $validPrefixes)) {
            return false;
        }

        return '00' . $msisdn; // final format like 00994501234567
    }
}
