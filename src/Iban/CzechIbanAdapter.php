<?php

namespace rikudou\EuQrPayment\Iban;

use rikudou\EuQrPayment\Helper\ToStringIban;
use rikudou\EuQrPayment\Iban\Validator\CompoundValidator;
use rikudou\EuQrPayment\Iban\Validator\CzechIbanValidator;
use rikudou\EuQrPayment\Iban\Validator\GenericIbanValidator;
use Rikudou\Iban\Validator\ValidatorInterface;

class CzechIbanAdapter implements IbanInterface
{
    use ToStringIban;

    /**
     * @var string
     */
    private $accountNumber;

    /**
     * @var string
     */
    private $bankCode;

    /**
     * @var string|null
     */
    private $iban = null;

    public function __construct(string $accountNumber, string $bankCode)
    {
        $this->accountNumber = $accountNumber;
        $this->bankCode = $bankCode;
    }

    /**
     * Returns the resulting IBAN.
     *
     * @return string
     */
    public function asString(): string
    {
        if (is_null($this->iban)) {
            $part1 = ord('C') - ord('A') + 10;
            $part2 = ord('Z') - ord('A') + 10;

            $accountPrefix = 0;
            $accountNumber = $this->accountNumber;
            if (strpos($accountNumber, '-') !== false) {
                $accountParts = explode('-', $accountNumber);
                $accountPrefix = $accountParts[0];
                $accountNumber = $accountParts[1];
            }

            $numeric = sprintf('%04d%06d%010d%d%d00', $this->bankCode, $accountPrefix, $accountNumber, $part1, $part2);

            $mod = '';
            foreach (str_split($numeric) as $n) {
                $mod = ($mod . $n) % 97;
            }
            $mod = intval($mod);

            $this->iban = sprintf('%.2s%02d%04d%06d%010d', 'CZ', 98 - $mod, $this->bankCode, $accountPrefix, $accountNumber);
        }

        return $this->iban;
    }

    /**
     * Returns the validator that checks whether the IBAN is valid.
     *
     * @return ValidatorInterface|null
     */
    public function getValidator(): ?ValidatorInterface
    {
        return new CompoundValidator(
            new CzechIbanValidator($this->accountNumber, $this->bankCode),
            new GenericIbanValidator($this)
        );
    }
}
