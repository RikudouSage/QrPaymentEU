<?php

namespace rikudou\EuQrPayment\Tests;

use rikudou\EuQrPayment\Helper\Utils;
use PHPUnit\Framework\TestCase;
use rikudou\EuQrPayment\Iban\IBAN;
use rikudou\EuQrPayment\Tests\Data\ConstantsClass;

class UtilsTest extends TestCase
{

    public function testGetConstants()
    {
        $this->assertEquals([], Utils::getConstants(\stdClass::class));
        $this->assertEquals([
            "NAME1" => "value1",
            "NAME2" => "value2"
        ], Utils::getConstants(ConstantsClass::class));

        $this->expectException(\InvalidArgumentException::class);
        Utils::getConstants("NonExistentClass");
    }

    public function testGetType()
    {
        $tmpFile = tempnam(sys_get_temp_dir(), "qrPaymentEuTest");

        $string = "string";
        $int = 1;
        $bool = true;
        $null = null;
        $array = [];
        $class1 = new \stdClass();
        $class2 = new IBAN("CZ5530300000001325090010");
        $stream = fopen($tmpFile, "r");

        $this->assertEquals("string", Utils::getType($string));
        $this->assertEquals("integer", Utils::getType($int));
        $this->assertEquals("boolean", Utils::getType($bool));
        $this->assertEquals("NULL", Utils::getType($null));
        $this->assertEquals("array", Utils::getType($array));
        $this->assertEquals("stdClass", Utils::getType($class1));
        $this->assertEquals("rikudou\EuQrPayment\Iban\IBAN", Utils::getType($class2));
        $this->assertEquals("resource (stream)", Utils::getType($stream));

        fclose($stream);
        unlink($tmpFile);
    }
}
