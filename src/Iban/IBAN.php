<?php

namespace rikudou\EuQrPayment\Iban;

use rikudou\EuQrPayment\Helper\ToStringIban;
use rikudou\EuQrPayment\Iban\Validator\GenericIbanValidator;
use rikudou\EuQrPayment\Iban\Validator\ValidatorInterface;

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
     * Returns the resulting IBAN.
     *
     * @return string
     */
    public function getIban(): string
    {
        return $this->iban;
    }

    /**
     * Returns the validator that checks whether the IBAN is valid.
     *
     * @return ValidatorInterface|null
     */
    public function getValidator(): ?ValidatorInterface
    {
        return new GenericIbanValidator($this);
    }
}
