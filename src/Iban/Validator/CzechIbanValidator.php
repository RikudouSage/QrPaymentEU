<?php

namespace rikudou\EuQrPayment\Iban\Validator;

class CzechIbanValidator implements ValidatorInterface
{
    // Modifiers according to Czech National Bank
    private const MODIFIERS = [
        6,
        3,
        7,
        9,
        10,
        5,
        8,
        4,
        2,
        1,
    ];

    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $bank;

    public function __construct(string $account, string $bank)
    {
        $this->account = $account;
        $this->bank = $bank;
    }

    public function isValid(): bool
    {
        // optional prefix that must be 1 to 6 characters long and account number between 1 and 10 characters long
        if (!preg_match('@^(?:([0-9]{0,6})-)?([0-9]{1,10})$@', $this->account, $matches)) {
            return false;
        }

        // prefix uses only the last six modifiers
        $prefixModifiers = array_slice(static::MODIFIERS, -6);

        $prefix = sprintf('%06d', $matches[1] ?? '');
        // the number could be too large on 32 bits, cannot use sprintf here
        $account = str_repeat('0', 10 - strlen($matches[2])) . $matches[2];

        $modPrefix = 0;
        for ($i = 0; $i < 6; $i++) {
            $modPrefix += $prefix[$i] * $prefixModifiers[$i];
        }
        $modPrefix = $modPrefix % 11;

        if ($modPrefix !== 0) {
            return false;
        }

        $modAccount = 0;
        for ($i = 0; $i < 10; $i++) {
            $modAccount += $account[$i] * static::MODIFIERS[$i];
        }
        $modAccount = $modAccount % 11;

        if ($modAccount !== 0) {
            return false;
        }

        return true;
    }
}
