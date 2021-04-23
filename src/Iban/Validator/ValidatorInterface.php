<?php

namespace rikudou\EuQrPayment\Iban\Validator;

use Rikudou\Iban\Validator\ValidatorInterface as BundledValidatorInterface;

interface ValidatorInterface extends BundledValidatorInterface
{
    public function isValid(): bool;
}
