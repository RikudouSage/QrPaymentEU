<?php

namespace rikudou\EuQrPayment\Tests;

use PHPUnit\Framework\TestCase;
use rikudou\EuQrPayment\Helper\Utils;
use rikudou\EuQrPayment\Iban\IBAN;
use rikudou\EuQrPayment\Tests\Data\ConstantsClass;

class UtilsTest extends TestCase
{
    public function testGetConstants()
    {
        $this->assertEquals([], Utils::getConstants(\stdClass::class));
        $this->assertEquals([
            'NAME1' => 'value1',
            'NAME2' => 'value2',
        ], Utils::getConstants(ConstantsClass::class));

        $this->expectException(\InvalidArgumentException::class);
        Utils::getConstants('NonExistentClass');
    }

    public function testGetType()
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'qrPaymentEuTest');

        $string = 'string';
        $int = 1;
        $bool = true;
        $null = null;
        $array = [];
        $class1 = new \stdClass();
        $class2 = new IBAN('CZ5530300000001325090010');
        $stream = fopen($tmpFile, 'r');

        $this->assertEquals('string', Utils::getType($string));
        $this->assertEquals('integer', Utils::getType($int));
        $this->assertEquals('boolean', Utils::getType($bool));
        $this->assertEquals('NULL', Utils::getType($null));
        $this->assertEquals('array', Utils::getType($array));
        $this->assertEquals('stdClass', Utils::getType($class1));
        $this->assertEquals("rikudou\EuQrPayment\Iban\IBAN", Utils::getType($class2));
        $this->assertEquals('resource (stream)', Utils::getType($stream));

        fclose($stream);
        unlink($tmpFile);
    }

    public function testBcmod()
    {
        for ($i = 0; $i <= 1; $i++) {
            $forceCustomImplementation = !!$i;

            $this->assertEquals('1', Utils::bcmod(11, 2, $forceCustomImplementation));
            $this->assertEquals('3', Utils::bcmod('8728932001983192837219398127471', 7, $forceCustomImplementation));
            $this->assertEquals('663577', Utils::bcmod('87289320019831928372193981274715795247', 1145678, $forceCustomImplementation));
        }
    }

    public function testBcmodNonNumericDividend()
    {
        $this->expectException(\InvalidArgumentException::class);
        Utils::bcmod('test', 123);
    }

    public function testBcmodNonNumericDivisor()
    {
        $this->expectException(\InvalidArgumentException::class);
        Utils::bcmod(123, 't');
    }

    public function testBcmodTooBigDivisor()
    {
        $this->expectException(\InvalidArgumentException::class);
        Utils::bcmod(1, '87289320019831928372193981274715795247', true);
    }

    public function testBcmodNegativeNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        Utils::bcmod(-5, 1, true);
    }
}
