<?php

namespace rikudou\EuQrPayment\Iban;

class IBAN implements IbanInterface
{

    /**
     * @var string
     */
    private $iban;

    public function __construct(string $iban)
    {
        $this->iban = $iban;
    }

    /**
     * Returns the resulting IBAN
     *
     * @return string
     */
    public function getIban(): string
    {
        return $this->iban;
    }
}