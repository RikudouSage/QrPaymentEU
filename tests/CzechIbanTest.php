<?php

namespace rikudou\EuQrPayment\Tests;

use PHPUnit\Framework\TestCase;
use rikudou\EuQrPayment\Iban\CzechIban;

class CzechIbanTest extends TestCase
{

    public function testGetIban()
    {
        $iban = new CzechIban($this->getAccountNumber(), $this->getBankCode());
        $this->assertEquals($this->getIban(), $iban->getIban());
    }

    public function testToString()
    {
        $iban = new CzechIban($this->getAccountNumber(), $this->getBankCode());
        $this->assertEquals($this->getIban(), strval($iban));
    }

    private function getAccountNumber(): int
    {
        return 1325090010;
    }

    private function getBankCode(): int
    {
        return 3030;
    }

    private function getIban(): string
    {
        return "CZ5530300000001325090010";
    }
}
