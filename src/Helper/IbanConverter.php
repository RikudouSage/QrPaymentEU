<?php

namespace rikudou\EuQrPayment\Helper;

use ReflectionProperty;
use rikudou\EuQrPayment\Iban\ConvertedIban;
use rikudou\EuQrPayment\Iban\CzechIbanAdapter as BundledCzechIban;
use rikudou\EuQrPayment\Iban\IBAN as BundledIban;
use rikudou\EuQrPayment\Iban\IbanInterface as BundledIbanInterface;
use Rikudou\Iban\Iban\CzechIbanAdapter as LibraryCzechIban;
use Rikudou\Iban\Iban\IBAN as LibraryIban;
use Rikudou\Iban\Iban\IbanInterface as LibraryIbanInterface;

/**
 * @internal
 */
final class IbanConverter
{
    public function convert(BundledIbanInterface $iban): LibraryIbanInterface
    {
        if ($iban instanceof BundledIban) {
            return new LibraryIban($iban->asString());
        } elseif ($iban instanceof BundledCzechIban) {
            $accountNumberReflection = new ReflectionProperty($iban, 'accountNumber');
            $accountNumberReflection->setAccessible(true);
            $bankCodeReflection = new ReflectionProperty($iban, 'bankCode');
            $bankCodeReflection->setAccessible(true);

            return new LibraryCzechIban($accountNumberReflection->getValue($iban), $bankCodeReflection->getValue($iban));
        }

        return new ConvertedIban($iban);
    }
}
