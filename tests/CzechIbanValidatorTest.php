<?php

namespace rikudou\EuQrPayment\Tests;

use PHPUnit\Framework\TestCase;
use rikudou\EuQrPayment\Iban\Validator\CzechIbanValidator;

class CzechIbanValidatorTest extends TestCase
{

    public function testIsValid()
    {
        foreach ($this->getAccounts() as $account) {
            $this->assertEquals($account["valid"], (new CzechIbanValidator(...$account["account"]))->isValid());
        }
    }

    private function getAccounts()
    {
        return [
            [
                "account" => [1325090010, 3030],
                "valid" => true
            ],
            [
                "account" => [1325090053, 3030],
                "valid" => true
            ],
            [
                "account" => [281115217, "0300"],
                "valid" => true
            ],
            [
                "account" => [500114004, 2700],
                "valid" => true
            ],
            [
                "account" => ["1011-17929051", "0710"],
                "valid" => true
            ],
            [
                "account" => ["21012-27924051", "0710"],
                "valid" => true
            ],
            [
                // random invalid account
                "account" => [123456, 1234],
                "valid" => false
            ],
            [
                // invalid prefix, valid account
                "account" => ["1-1325090010", 3030],
                "valid" => false
            ],
            [
                // too long prefix, valid account
                "account" => ["1234567-1325090010", 3030],
                "valid" => false
            ],
            [
                // too long account
                "account" => [13250900101, 3030],
                "valid" => false
            ]
        ];
    }
}
