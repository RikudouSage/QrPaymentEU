<?php

namespace rikudou\EuQrPayment;

use DateTimeInterface;
use Endroid\QrCode\QrCode;
use InvalidArgumentException;
use LogicException;
use rikudou\EuQrPayment\Config\Configuration;
use rikudou\EuQrPayment\Config\ConfigurationInterface;
use rikudou\EuQrPayment\Exceptions\InvalidIbanException;
use rikudou\EuQrPayment\Exceptions\InvalidOptionException;
use rikudou\EuQrPayment\Exceptions\UnsupportedMethodException;
use rikudou\EuQrPayment\Helper\IbanConverter;
use rikudou\EuQrPayment\Helper\Utils;
use rikudou\EuQrPayment\Iban\IBAN;
use rikudou\EuQrPayment\Iban\IbanInterface as BundledIbanInterface;
use rikudou\EuQrPayment\Sepa\CharacterSet;
use Rikudou\Iban\Iban\IbanInterface as LibraryIbanInterface;
use Rikudou\QrPayment\QrPaymentInterface;

final class QrPayment implements QrPaymentInterface
{
    /**
     * @var LibraryIbanInterface
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
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @param string|BundledIbanInterface|LibraryIbanInterface $iban
     */
    public function __construct($iban, ?ConfigurationInterface $configuration = null)
    {
        if (is_string($iban)) {
            $iban = new IBAN($iban);
        }
        if ($iban instanceof BundledIbanInterface) {
            trigger_error(sprintf(
                'The class "%s" is deprecated, please switch to "%s"',
                BundledIbanInterface::class,
                LibraryIbanInterface::class
            ), E_USER_DEPRECATED);
            $converter = new IbanConverter();
            $iban = $converter->convert($iban);
        }
        if (!$iban instanceof LibraryIbanInterface) {
            throw new InvalidArgumentException('The IBAN must be a string or ' . LibraryIbanInterface::class . ', ' . Utils::getType($iban) . ' given');
        }
        if ($configuration === null) {
            $configuration = new Configuration();
        }
        $this->iban = $iban;
        $this->configuration = $configuration;
    }

    /**
     * Returns the provided IBAN.
     *
     * @return LibraryIbanInterface
     */
    public function getIban(): LibraryIbanInterface
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
            throw new InvalidArgumentException("Invalid character set: {$characterSet}");
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
            throw new InvalidArgumentException('The amount cannot be less than 0');
        }
        if ($amount > 999999999.99) {
            throw new InvalidArgumentException('The maximum amount is 999,999,999.99');
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
                throw new InvalidIbanException('The IBAN is not valid');
            }
        }

        if ($this->getAmount()) {
            $amount = $this->configuration->getAmountPrecision() !== null
                ? number_format($this->getAmount(), $this->configuration->getAmountPrecision(), '.', '')
                : $this->getAmount();
        } else {
            $amount = '';
        }

        $result[] = 'BCD'; // the service tag
        $result[] = $this->configuration->getVersion();
        $result[] = $this->getCharacterSet();
        $result[] = 'SCT'; // identification
        $result[] = $this->getBic();
        $result[] = $this->getBeneficiaryName();
        $result[] = $this->getIban()->asString();
        $result[] = $amount ? $this->getCurrency() . $amount : '';
        $result[] = $this->getPurpose();
        $result[] = $this->getRemittanceText();
        $result[] = $this->getInformation();
        foreach ($this->configuration->getCustomData() as $customDatum) {
            $result[] = $customDatum;
        }

        $result = implode("\n", $result);

        $byteLength = strlen($result);

        if ($byteLength > 331) {
            throw new LogicException("The resulting QR string is limited to 331 bytes, yours has {$byteLength} bytes");
        }

        return $result;
    }

    /**
     * Return QrCode object with QrString set, for more info see Endroid QrCode
     * documentation.
     *
     * @return QrCode
     */
    public function getQrImage(): QrCode
    {
        if (!class_exists("Endroid\QrCode\QrCode")) {
            throw new LogicException('Error: library endroid/qr-code is not loaded.');
        }

        return new QrCode($this->getQrString());
    }

    /**
     * @param array<string, string|float|int> $options
     *
     * @return QrPayment
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $methodName = 'set' . ucfirst($key);
            if (method_exists($this, $methodName)) {
                /** @phpstan-ignore-next-line */
                call_user_func([$this, $methodName], $value);
            } else {
                throw new InvalidOptionException("The option '{$key}' is invalid");
            }
        }

        return $this;
    }

    public function setDueDate(DateTimeInterface $dueDate)
    {
        if ($handler = $this->configuration->getDueDateHandler()) {
            $handler->setDueDate($dueDate);

            return $this;
        }
        throw new UnsupportedMethodException('The European standard does not support setting due date');
    }

    public function getDueDate(): DateTimeInterface
    {
        if ($handler = $this->configuration->getDueDateHandler()) {
            return $handler->getDueDate();
        }
        throw new UnsupportedMethodException('The European standard does not support setting due date');
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
            throw new InvalidArgumentException("The string should be between {$min} and {$max} characters long, your string contains {$length} characters");
        }
    }

    private function checkRequiredParameters(): void
    {
        if (!$this->getBeneficiaryName()) {
            throw new LogicException('The beneficiary name is a mandatory parameter');
        }
    }
}
