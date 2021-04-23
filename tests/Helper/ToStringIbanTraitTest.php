<?php

namespace rikudou\EuQrPayment\Tests\Helper;

use PHPUnit\Framework\TestCase;
use rikudou\EuQrPayment\Helper\ToStringIban;

class ToStringIbanTraitTest extends TestCase
{
    public function testValid()
    {
        $obj = new class() {
            use ToStringIban;

            public function asString(): string
            {
                return 'testString';
            }
        };

        $this->assertEquals('testString', strval($obj));
    }

    public function testInvalidNoMethod()
    {
        $obj = new class() {
            use ToStringIban;
        };

        $this->assertEquals('', strval($obj));
    }

    public function testInvalidExceptionThrown()
    {
        $obj = new class() {
            use ToStringIban;

            public function asString(): string
            {
                throw new \Exception();
            }
        };

        $this->assertEquals('', strval($obj));
    }
}
