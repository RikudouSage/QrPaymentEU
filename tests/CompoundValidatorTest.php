<?php

namespace rikudou\EuQrPayment\Tests;

use PHPUnit\Framework\TestCase;
use rikudou\EuQrPayment\Iban\IBAN;
use rikudou\EuQrPayment\Iban\Validator\CompoundValidator;
use rikudou\EuQrPayment\Iban\Validator\CzechIbanValidator;
use rikudou\EuQrPayment\Iban\Validator\GenericIbanValidator;
use rikudou\EuQrPayment\Iban\Validator\ValidatorInterface;

class CompoundValidatorTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testConstructor()
    {
        new CompoundValidator(
            new GenericIbanValidator(new IBAN('')),
            new CzechIbanValidator('123', '123')
        );
    }

    public function testConstructorWithNoArguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        new CompoundValidator();
    }

    public function testIsValid()
    {
        $valid1 = new CompoundValidator($this->validGenericValidator());
        $valid2 = new CompoundValidator($this->validCzechValidator());
        $valid3 = new CompoundValidator($this->validFakeValidator());
        $valid4 = new CompoundValidator(
            $this->validGenericValidator(),
            $this->validCzechValidator(),
            $this->validFakeValidator()
        );

        $invalid1 = new CompoundValidator($this->invalidGenericValidator());
        $invalid2 = new CompoundValidator($this->invalidCzechValidator());
        $invalid3 = new CompoundValidator($this->invalidFakeValidator());
        $invalid4 = new CompoundValidator(
            $this->invalidGenericValidator(),
            $this->invalidCzechValidator(),
            $this->invalidFakeValidator()
        );

        $mixed1 = new CompoundValidator(
            $this->validGenericValidator(),
            $this->invalidFakeValidator()
        );
        $mixed2 = new CompoundValidator(
            $this->validFakeValidator(),
            $this->validGenericValidator(),
            $this->validCzechValidator(),
            $this->invalidFakeValidator(),
            $this->invalidCzechValidator(),
            $this->invalidGenericValidator()
        );

        $this->assertTrue($valid1->isValid());
        $this->assertTrue($valid2->isValid());
        $this->assertTrue($valid3->isValid());
        $this->assertTrue($valid4->isValid());
        $this->assertFalse($invalid1->isValid());
        $this->assertFalse($invalid2->isValid());
        $this->assertFalse($invalid3->isValid());
        $this->assertFalse($invalid4->isValid());
        $this->assertFalse($mixed1->isValid());
        $this->assertFalse($mixed2->isValid());
    }

    private function validGenericValidator(): GenericIbanValidator
    {
        return new GenericIbanValidator(new IBAN('CZ5530300000001325090010'));
    }

    private function invalidGenericValidator(): GenericIbanValidator
    {
        return new GenericIbanValidator(new IBAN('CZ5530300000001325090011'));
    }

    private function validCzechValidator(): CzechIbanValidator
    {
        return new CzechIbanValidator('1325090010', '3030');
    }

    private function invalidCzechValidator(): CzechIbanValidator
    {
        return new CzechIbanValidator('1325090011', '3030');
    }

    private function validFakeValidator(): ValidatorInterface
    {
        return new class() implements ValidatorInterface {
            public function isValid(): bool
            {
                return true;
            }
        };
    }

    private function invalidFakeValidator(): ValidatorInterface
    {
        return new class() implements ValidatorInterface {
            public function isValid(): bool
            {
                return false;
            }
        };
    }
}
