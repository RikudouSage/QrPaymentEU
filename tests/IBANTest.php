<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 15.12.18
 * Time: 2:11.
 */

namespace rikudou\EuQrPayment\Tests;

use PHPUnit\Framework\TestCase;
use rikudou\EuQrPayment\Iban\IBAN;

class IBANTest extends TestCase
{
    public function testGetIban()
    {
        $iban = new IBAN($this->getIbanString());
        $this->assertEquals($this->getIbanString(), $iban->asString());
    }

    public function testToString()
    {
        $iban = new IBAN($this->getIbanString());
        $this->assertEquals($this->getIbanString(), strval($iban));
    }

    public function testGetValidator()
    {
        $this->assertEquals(true, (new IBAN($this->getIbanString()))->getValidator()->isValid());
    }

    private function getIbanString(): string
    {
        return 'CZ5530300000001325090010';
    }
}
