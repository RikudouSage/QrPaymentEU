<?php

namespace rikudou\EuQrPayment\Iban\Validator;

use rikudou\EuQrPayment\Helper\Utils;
use rikudou\EuQrPayment\Iban\IbanInterface;

class GenericIbanValidator implements ValidatorInterface
{

    private const IBAN_LENGTHS = [

    ];

    /**
     * @var IbanInterface
     */
    private $iban;

    public function __construct(IbanInterface $iban)
    {
        $this->iban = $iban;
    }

    public function isValid(): bool
    {
        $stringIban = strtoupper($this->iban->getIban());

        $country = substr($stringIban, 0, 2);
        $checksum = substr($stringIban, 2, 2);
        $account = substr($stringIban, 4);
        $numericCountry = $this->getNumericRepresentation($country);
        $numericAccount = $this->getNumericRepresentation($account);

        $inverted = $numericAccount . $numericCountry . $checksum;
        return Utils::bcmod($inverted, 97) === '1';
    }

    private function getNumericRepresentation(string $string)
    {
        $result = "";
        $length = strlen($string);
        for ($i = 0; $i < $length; $i++) {
            $char = $string[$i];
            if(!is_numeric($char)) {
                $result .= ord($char) - ord('A') + 10;
            } else {
                $result .= $char;
            }
        }

        return $result;
    }
}