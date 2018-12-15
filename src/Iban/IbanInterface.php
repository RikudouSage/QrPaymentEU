<?php

namespace rikudou\EuQrPayment\Iban;

interface IbanInterface
{

    /**
     * Returns the resulting IBAN
     *
     * @throws \Exception if the iban is not valid
     * @return string
     */
    public function getIban(): string;

    /**
     * Returns the resulting IBAN, returns empty string if the IBAN is not valid
     *
     * @return string
     */
    public function __toString();

}