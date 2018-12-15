<?php

namespace rikudou\EuQrPayment\Iban;

use rikudou\EuQrPayment\Helper\ToStringIban;

class IBAN implements IbanInterface
{

    use ToStringIban;

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