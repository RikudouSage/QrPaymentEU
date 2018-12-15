# QR code payment (EU)

Library to generate QR payment codes for European Union (EPC standard).

> See also QR code payment generator for [Czech](https://github.com/RikudouSage/QrPaymentCZ) or [Slovak](https://github.com/RikudouSage/QrPaymentSK) accounts

> As this is currently a beta release, the public api is not stable and may change anytime.

## Installation

Via composer: `composer require rikudou/euqrpayment`

## Usage

In the constructor you must supply IBAN which may be a string
or an instance of `rikudou\EuQrPayment\Iban\IbanInterface`.

Example with string:

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");

```

Example with base IBAN class:

```php
<?php

use rikudou\EuQrPayment\QrPayment;
use rikudou\EuQrPayment\Iban\IBAN;

$payment = new QrPayment(new IBAN("CZ5530300000001325090010"));

```

The `IbanInterface` is useful in case you want to create an
adapter that transforms your local format (*BBAN*) to IBAN.

This package contains one such class for Czech accounts:

```php
<?php

use rikudou\EuQrPayment\QrPayment;
use rikudou\EuQrPayment\Iban\CzechIban;

$payment = new QrPayment(new CzechIban(1325090010, 3030));

```

### Setting payment details

All payment details can be set via setters:

```php
<?php

use rikudou\EuQrPayment\QrPayment;
use rikudou\EuQrPayment\Sepa\CharacterSet;
use rikudou\EuQrPayment\Sepa\Purpose;

$payment = new QrPayment("CZ5530300000001325090010");
$payment
    ->setCharacterSet(CharacterSet::UTF_8)
    ->setBic("AIRACZPP")
    ->setBeneficiaryName("My Cool Company")
    ->setAmount(100)
    ->setPurpose(Purpose::ACCOUNT_MANAGEMENT)
    ->setRemittanceText("Invoice ID: XXX")
    ->setInformation("This is some note")
    ->setCurrency("EUR");

```

## Exceptions

This library throws `LogicException` and `InvalidArgumentException`, here is a list of methods
that throw exceptions and the reason for that:

- `__construct()` - `InvalidArgumentException` - if the `$iban` parameter is not a string or
instance of `rikudou\EuQrPayment\Iban\IbanInterface`
- `setBic()` and `setSwift()` - `InvalidArgumentException` - if the BIC is shorter than 8
characters or longer than 11 characters
- `setBeneficiaryName()` - `InvalidArgumentException` - if the beneficiary name is longer
than 70 characters
- `setAmount()` - `InvalidArgumentException` - if the amount is lower than zero
- `setPurpose()` - `InvalidArgumentException` - if the purpose is longer than 4 characters
- `setRemittanceText()` - `InvalidArgumentException` - if the remittance text is longer
than 140 characters
- `setInformation()` and `setComment()` - `InvalidArgumentException` - if the comment is longer
than 70 characters
- `setCurrency()` - `InvalidArgumentException` - if the currency is not exactly 3 characters
long
- `getQrString()` - `LogicException` - if the character set is not a valid character set,
if the beneficiary name is missing or if the resulting string is bigger than 331 bytes
- `getQrImage()` - `LogicException` - if the `endroid/qr-code` library is not installed

## List of public methods

### Constructor

**Params**

- `string|IbanInterface $iban` - The IBAN

**Example**
```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");
```

### getIban()

Returns instance of `IbanInterface`, you can get the string
representation of IBAN via method `getIban()` of `IbanInterface`.

**Returns**

`rikudou\EuQrPayment\Iban\IbanInterface`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");
$iban = $payment->getIban(); // holds instance of rikudou\EuQrPayment\Iban\IBAN
$ibanAsString = $payment->getIban()->getIban();

```

### getCharacterSet()

Returns the character set as integer from specification.
You can check it against `rikudou\EuQrPayment\Sepa\CharacterSet`
constants. Defaults to 1 (utf-8).

**Returns**

`int`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;
use rikudou\EuQrPayment\Sepa\CharacterSet;

$payment = new QrPayment("CZ5530300000001325090010");

switch ($payment->getCharacterSet()) {
    case CharacterSet::UTF_8:
        echo "UTF-8";
        break;
    case CharacterSet::ISO_8859_1:
        echo "ISO-8859-1";
        break;
    case CharacterSet::ISO_8859_2:
        echo "ISO-8859-2";
        break;
    case CharacterSet::ISO_8859_4:
        echo "ISO-8859-4";
        break;
    case CharacterSet::ISO_8859_5:
        echo "ISO-8859-5";
        break;
    case CharacterSet::ISO_8859_7:
        echo "ISO-8859-7";
        break;
    case CharacterSet::ISO_8859_10:
        echo "ISO-8859-10";
        break;
    case CharacterSet::ISO_8859_15:
        echo "ISO-8859-15";
        break;
    default:
        echo "I'm afraid that this character set does not exist, sir";
}

```

### getBic() or getSwift()

Returns the BIC (SWIFT) of the payment. `getSwift()` is alias
to `getBic()`. Defaults to empty string.

**Returns**

`string`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");

var_dump($payment->getSwift());
var_dump($payment->getBic());

```

### getBeneficiaryName()

Returns the name of the beneficiary. Defaults to empty string.

**Returns**

`string`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");
$payment->getBeneficiaryName();

```

### getAmount()

Returns the amount of the payment. Defaults to `0.0`.

**Returns**

`float`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");

$payment->getAmount();
```

### getPurpose()

Returns the purpose text, you can check it against the
`rikudou\EuQrPayment\Sepa\Purpose` constants. Defaults to
empty string.

**Returns**

`string`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;
use rikudou\EuQrPayment\Sepa\Purpose;

$payment = new QrPayment("CZ5530300000001325090010");
if($payment->getPurpose() === Purpose::ACCOUNT_MANAGEMENT) {
    // do something related to account management
} else if($payment->getPurpose() === Purpose::ALIMONY_PAYMENT) {
    // handle alimony payment
} else {
    // etc.
}
```

### getRemittanceText()

Returns the remittance text, e.g. payment reference. Defaults
to empty string.

**Returns**

`string`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");

$payment->getRemittanceText();
```

### getInformation() or getComment()

Returns the information (comment) of the payment.
`getComment()` is alias to `getInformation()`. Defaults to
empty string.

**Returns**

`string`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");

$payment->getInformation();
$payment->getComment();
```

### getCurrency()

Returns the currency of the payment. Defaults to `EUR`.

**Returns**

`string`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");

if($payment->getCurrency() === "EUR") {
    // do something
}
```

### setCharacterSet()

Sets the character set.

**Params**

- `int $characterSet` - one of the supported character sets from `rikudou\EuQrPayment\Sepa\CharacterSet`

**Returns**

`$this`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;
use rikudou\EuQrPayment\Sepa\CharacterSet;

$payment = new QrPayment("CZ5530300000001325090010");
$payment->setCharacterSet(CharacterSet::UTF_8);
```

### setBic() or setSwift()

Sets the BIC (SWIFT) for the payment. `setSwift()` is alias to `setBic()`.

**Params**

- `string $bic` - your bank's BIC (SWIFT)

**Returns**

`$this`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");
$payment->setBic("AIRACZPP");
$payment->setSwift("AIRACZPP");
```

### setBeneficiaryName()

Sets the name of the beneficiary, this parameter is required.

**Params**

- `string $beneficiaryName` - the name of the beneficiary

**Returns**

`$this`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");
$payment->setBeneficiaryName("My Cool Company");
```

### setAmount()

Sets the payment amount.

**Params**

- `float $amount` - The amount

**Returns**

`$this`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");
$payment->setAmount(10);
```

### setPurpose()

Sets the purpose according to SEPA specification, use class `rikudou\EuQrPayment\Sepa\Purpose`.

**Params**

- `string $purpose` - The purpose

**Returns**

`$this`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;
use rikudou\EuQrPayment\Sepa\Purpose;

$payment = new QrPayment("CZ5530300000001325090010");
$payment->setPurpose(Purpose::TRUST_FUND);
```

### setRemittanceText()

The payment reference, up to 140 characters.

**Params**

- `string $remittanceText` - the remittance text

**Returns**

`$this`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");
$payment->setRemittanceText("Invoice ID: ###");
```

### setInformation() or setComment()

Comment for the payment, up to 70 characters. `setComment()` is alias to `setInformation()`.

**Params**

- `string $information` - the information text

**Returns**

`$this`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");
$payment->setInformation("QR PAYMENT");
$payment->setComment("QR PAYMENT");
```

### setCurrency()

Sets the currency of the payment, must be an [ISO 4217](https://en.wikipedia.org/wiki/ISO_4217)
string.

**Params**

- `string $currency` - the currency according to ISO 4217

**Returns**

`$this`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;

$payment = new QrPayment("CZ5530300000001325090010");
$payment->setCurrency("EUR");
```

### getQrString()

Returns the string that should be encoded in QR image.

**Returns**

`string`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;
use rikudou\EuQrPayment\Sepa\CharacterSet;
use rikudou\EuQrPayment\Sepa\Purpose;

$payment = new QrPayment("CZ5530300000001325090010");
$payment
    ->setCharacterSet(CharacterSet::UTF_8)
    ->setBic("AIRACZPP")
    ->setBeneficiaryName("My Cool Company")
    ->setAmount(100)
    ->setPurpose(Purpose::ACCOUNT_MANAGEMENT)
    ->setRemittanceText("Invoice ID: XXX")
    ->setInformation("This is some note")
    ->setCurrency("EUR");

var_dump($payment->getQrString());

/*
Output:

string(109) "BCD
002
1
SCT
AIRACZPP
My Cool Company
CZ5530300000001325090010
EUR100
ACCT
Invoice ID: XXX
This is some note"
 */
```

### getQrImage()

Returns a Qr code via third-party library.

**Returns**

`\Endroid\QrCode\QrCode`

**Example**

```php
<?php

use rikudou\EuQrPayment\QrPayment;
use rikudou\EuQrPayment\Sepa\CharacterSet;
use rikudou\EuQrPayment\Sepa\Purpose;

$payment = new QrPayment("CZ5530300000001325090010");
$payment
    ->setCharacterSet(CharacterSet::UTF_8)
    ->setBic("AIRACZPP")
    ->setBeneficiaryName("My Cool Company")
    ->setAmount(100)
    ->setPurpose(Purpose::ACCOUNT_MANAGEMENT)
    ->setRemittanceText("Invoice ID: XXX")
    ->setInformation("This is some note")
    ->setCurrency("EUR");

header("Content-Type: image/png");
echo $payment->getQrString()->writeString();

```

## The Purpose class

The class is generated via script `createLists.php` as it downloads the XLS file that
documents all the purpose strings. The class is committed to git so that there doesn't
have to be any remote file downloading etc. when using this package in production.

After generating the class you should check that there are no errors as the code that
generates it is most likely not bullet-proof.
