<?php

namespace rikudou\EuQrPayment;

use Endroid\QrCode\QrCode;
use rikudou\EuQrPayment\Exceptions\InvalidIbanException;
use rikudou\EuQrPayment\Helper\Utils;
use rikudou\EuQrPayment\Iban\IBAN;
use rikudou\EuQrPayment\Iban\IbanInterface;
use rikudou\EuQrPayment\Sepa\CharacterSet;

final class QrPayment
{
    /**
     * @var IbanInterface
     */
    private $iban;

    /**
     * @var int
     */
    private $characterSet = CharacterSet::UTF_8;

    /**
     * @var string
     */
    private $bic = '';

    /**
     * @var string
     */
    private $beneficiaryName = '';

    /**
     * @var float
     */
    private $amount = 0.0;

    /**
     * @var string
     */
    private $purpose = '';

    /**
     * @var string
     */
    private $remittanceText = '';

    /**
     * @var string
     */
    private $information = '';

    /**
     * @var string
     */
    private $currency = 'EUR';

    /**
     * @param string|IbanInterface $iban
     */
    public function __construct($iban)
    {
        if (is_string($iban)) {
            $iban = new IBAN($iban);
        }
        if (!$iban instanceof IbanInterface) {
            throw new \InvalidArgumentException('The IBAN must be a string or ' . IbanInterface::class . ', ' . Utils::getType($iban) . ' given');
        }
        $this->iban = $iban;
    }

    /**
     * Returns the provided IBAN.
     *
     * @return IbanInterface
     */
    public function getIban(): IbanInterface
    {
        return $this->iban;
    }

    /**
     * Returns character set, @see CharacterSet.
     *
     * @return int
     */
    public function getCharacterSet(): int
    {
        return $this->characterSet;
    }

    /**
     * Set the character set, @see CharacterSet.
     *
     * @param int $characterSet
     *
     * @return QrPayment
     */
    public function setCharacterSet(int $characterSet): QrPayment
    {
        if (!in_array($characterSet, Utils::getConstants(CharacterSet::class))) {
            throw new \InvalidArgumentException("Invalid character set: {$characterSet}");
        }
        $this->characterSet = $characterSet;

        return $this;
    }

    /**
     * @return string
     */
    public function getBic(): string
    {
        return $this->bic;
    }

    /**
     * @param string $bic
     *
     * @return QrPayment
     */
    public function setBic(string $bic): QrPayment
    {
        $this->checkLength($bic, 11, 8);
        $this->bic = $bic;

        return $this;
    }

    /**
     * @alias to getBic()
     *
     * @return string
     */
    public function getSwift(): string
    {
        return $this->getBic();
    }

    /**
     * @alias to setBic()
     *
     * @param string $swift
     *
     * @return QrPayment
     */
    public function setSwift(string $swift): QrPayment
    {
        return $this->setBic($swift);
    }

    /**
     * @return string
     */
    public function getBeneficiaryName(): string
    {
        return $this->beneficiaryName;
    }

    /**
     * @param string $beneficiaryName
     *
     * @return QrPayment
     */
    public function setBeneficiaryName(string $beneficiaryName): QrPayment
    {
        $this->checkLength($beneficiaryName, 70);
        $this->beneficiaryName = $beneficiaryName;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return QrPayment
     */
    public function setAmount(float $amount): QrPayment
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('The amount cannot be less than 0');
        }
        if ($amount > 999999999.99) {
            throw new \InvalidArgumentException('The maximum amount is 999,999,999.99');
        }
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getPurpose(): string
    {
        return $this->purpose;
    }

    /**
     * @param string $purpose
     *
     * @return QrPayment
     */
    public function setPurpose(string $purpose): QrPayment
    {
        $this->checkLength($purpose, 4);
        $this->purpose = $purpose;

        return $this;
    }

    /**
     * @return string
     */
    public function getRemittanceText(): string
    {
        return $this->remittanceText;
    }

    /**
     * @param string $remittanceText
     *
     * @return QrPayment
     */
    public function setRemittanceText(string $remittanceText): QrPayment
    {
        $this->checkLength($remittanceText, 140);
        $this->remittanceText = $remittanceText;

        return $this;
    }

    /**
     * @return string
     */
    public function getInformation(): string
    {
        return $this->information;
    }

    /**
     * @param string $information
     *
     * @return QrPayment
     */
    public function setInformation(string $information): QrPayment
    {
        $this->checkLength($information, 70);
        $this->information = $information;

        return $this;
    }

    /**
     * @alias to setInformation()
     *
     * @param string $comment
     *
     * @return QrPayment
     */
    public function setComment(string $comment): QrPayment
    {
        return $this->setInformation($comment);
    }

    /**
     * @alias to getInformation()
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->getInformation();
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return QrPayment
     */
    public function setCurrency(string $currency): QrPayment
    {
        $this->checkLength($currency, 3, 3);
        $this->currency = $currency;

        return $this;
    }

    public function getQrString(): string
    {
        $this->checkRequiredParameters();

        $result = [];
        if ($validator = $this->getIban()->getValidator()) {
            if (!$validator->isValid()) {
                throw new InvalidIbanException("The IBAN is not valid");
            }
        }

        $result[] = 'BCD'; // the service tag
        $result[] = '002'; // version
        $result[] = $this->getCharacterSet();
        $result[] = 'SCT'; // identification
        $result[] = $this->getBic();
        $result[] = $this->getBeneficiaryName();
        $result[] = $this->getIban()->getIban();
        $result[] = $this->getAmount() ? $this->getCurrency() . $this->getAmount() : '';
        $result[] = $this->getPurpose();
        $result[] = $this->getRemittanceText();
        $result[] = $this->getInformation();

        $result = implode("\n", $result);

        $byteLength = strlen($result);

        if ($byteLength > 331) {
            throw new \LogicException("The resulting QR string is limited to 331 bytes, yours has {$byteLength} bytes");
        }

        return $result;
    }

    /**
     * Return QrCode object with QrString set, for more info see Endroid QrCode
     * documentation.
     *
     * @return \Endroid\QrCode\QrCode
     */
    public function getQrImage(): QrCode
    {
        if (!class_exists("Endroid\QrCode\QrCode")) {
            throw new \LogicException('Error: library endroid/qr-code is not loaded.');
        }

        return new QrCode($this->getQrString());
    }

    /**
     * @param string $string
     * @param int    $max
     * @param int    $min
     */
    private function checkLength(string $string, int $max, int $min = 1): void
    {
        $length = mb_strlen($string);
        if ($length > $max || $length < $min) {
            throw new \InvalidArgumentException("The string should be between {$min} and {$max} characters long, your string contains {$length} characters");
        }
    }

    private function checkRequiredParameters()
    {
        if (!$this->getBeneficiaryName()) {
            throw new \LogicException('The beneficiary name is a mandatory parameter');
        }
    }
}
