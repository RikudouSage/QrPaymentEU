<?php

namespace rikudou\EuQrPayment\Iban;

use rikudou\EuQrPayment\Iban\IbanInterface as BundledIbanInterface;
use Rikudou\Iban\Helper\ToStringIbanTrait;
use Rikudou\Iban\Iban\IbanInterface as LibraryIbanInterface;
use Rikudou\Iban\Validator\ValidatorInterface;

/**
 * @internal
 */
final class ConvertedIban implements LibraryIbanInterface
{
    use ToStringIbanTrait;

    /**
     * @var BundledIbanInterface
     */
    private $iban;

    public function __construct(BundledIbanInterface $iban)
    {
        $this->iban = $iban;
    }

    public function asString(): string
    {
        return $this->iban->asString();
    }

    public function getValidator(): ?ValidatorInterface
    {
        return $this->iban->getValidator();
    }
}
