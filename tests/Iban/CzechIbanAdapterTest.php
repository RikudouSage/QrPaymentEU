<?php

namespace rikudou\EuQrPayment\Tests\Iban;

use rikudou\EuQrPayment\Iban\CzechIbanAdapter;
use PHPUnit\Framework\TestCase;
use rikudou\EuQrPayment\Iban\Validator\ValidatorInterface;

class CzechIbanAdapterTest extends TestCase
{
    public function testAccountsWithoutPrefix()
    {
        $accounts = [
            'CZ55 3030 0000 0013 2509 0010' => [
                'acc' => '1325090010',
                'bank' => '3030',
            ],
            'CZ36 3030 0000 0013 2509 0061' => [
                'acc' => '1325090061',
                'bank' => '3030',
            ],
            'CZ91 0300 0000 0002 8111 5217' => [
                'acc' => '281115217',
                'bank' => '0300',
            ],
            'CZ52 0300 0000 0000 0398 3815' => [
                'acc' => '3983815',
                'bank' => '0300',
            ],
            'CZ13 2700 0000 0005 0011 4004' => [
                'acc' => '500114004',
                'bank' => '2700',
            ],
        ];

        foreach ($accounts as $iban => $accountData) {
            $iban = str_replace(' ', '', $iban);
            $this->assertEquals($iban, $this->getIban($accountData['acc'], $accountData['bank'])->asString());
            $this->assertEquals($iban, strval($this->getIban($accountData['acc'], $accountData['bank'])));
        }
    }

    public function testAccountsWithPrefix()
    {
        $accounts = [
            'CZ03 0710 0010 1100 1792 9051' => [
                'acc' => '17929051',
                'bank' => '0710',
                'prefix' => '1011',
            ],
            'CZ47 0710 0210 1200 2792 4051' => [
                'acc' => '27924051',
                'bank' => '0710',
                'prefix' => '21012',
            ],
        ];

        foreach ($accounts as $iban => $accountData) {
            $iban = str_replace(' ', '', $iban);
            $this->assertEquals($iban, $this->getIban($accountData['acc'], $accountData['bank'], $accountData['prefix'])->asString());
            $this->assertEquals($iban, strval($this->getIban($accountData['acc'], $accountData['bank'], $accountData['prefix'])));
        }
    }

    public function testGetValidator()
    {
        $this->assertInstanceOf(ValidatorInterface::class, $this->getIban(1325090010, 3030)->getValidator());
    }

    /**
     * @param string|int $account
     * @param string|int $bankCode
     * @param string|int|null $prefix
     *
     * @return CzechIbanAdapter
     */
    private function getIban($account, $bankCode, $prefix = null): CzechIbanAdapter
    {
        if (!is_null($prefix)) {
            $account = "{$prefix}-{$account}";
        }
        $ibanAdapter = new CzechIbanAdapter($account, $bankCode);

        return $ibanAdapter;
    }
}
