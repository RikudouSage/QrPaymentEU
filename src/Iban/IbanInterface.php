<?php

namespace rikudou\EuQrPayment\Iban;

use rikudou\EuQrPayment\Iban\Validator\ValidatorInterface;

interface IbanInterface
{
    /**
     * Returns the resulting IBAN, returns empty string if the IBAN is not valid.
     *
     * @return string
     */
    public function __toString();

    /**
     * Returns the resulting IBAN.
     *
     * @return string
     */
    public function asString(): string;

    /**
     * Returns the validator that checks whether the IBAN is valid.
     *
     * @return ValidatorInterface|null
     */
    public function getValidator(): ?ValidatorInterface;
}
