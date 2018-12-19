<?php

namespace rikudou\EuQrPayment\Iban\Validator;

interface ValidatorInterface
{

    public function isValid(): bool;

}