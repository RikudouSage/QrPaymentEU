<?php

namespace rikudou\EuQrPayment\Iban;

interface IbanInterface
{

    /**
     * Returns the resulting IBAN
     *
     * @return string
     */
    public function getIban(): string;

}