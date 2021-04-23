<?php

namespace rikudou\EuQrPayment\Tests\Config;

use DateTimeImmutable;
use DateTimeInterface;
use rikudou\EuQrPayment\Config\AbstractConfiguration;
use PHPUnit\Framework\TestCase;
use rikudou\EuQrPayment\Config\DueDateHandlerInterface;
use rikudou\EuQrPayment\Exceptions\UnsupportedMethodException;
use rikudou\EuQrPayment\Iban\CzechIbanAdapter;
use rikudou\EuQrPayment\QrPayment;

class AbstractConfigurationTest extends TestCase
{
    public function testGetVersion()
    {
        // test default
        $instance = $this->getInstance();
        self::assertEquals('002', $this->getLine($instance, 1));

        $config = new class extends AbstractConfiguration {
            public function getVersion(): string
            {
                return '001';
            }
        };
        $instance = $this->getInstance($config);
        self::assertEquals('001', $this->getLine($instance, 1));

        $config = new class extends AbstractConfiguration {
            public function getVersion(): string
            {
                return '002';
            }
        };
        $instance = $this->getInstance($config);
        self::assertEquals('002', $this->getLine($instance, 1));

        $config = new class extends AbstractConfiguration {
            public function getVersion(): string
            {
                return '003';
            }
        };
        $instance = $this->getInstance($config);
        self::assertEquals('003', $this->getLine($instance, 1));
    }

    public function testGetCustomData()
    {
        // test default
        $instance = $this->getInstance();
        self::assertCount(11, $this->getLines($instance));

        $config = new class extends AbstractConfiguration {
            public function getCustomData(): iterable
            {
                yield 'A';
                yield 'B';
            }
        };
        $instance = $this->getInstance($config);
        self::assertCount(13, $this->getLines($instance));
        self::assertEquals('A', $this->getLine($instance, 11));
        self::assertEquals('B', $this->getLine($instance, 12));
    }

    public function testGetAmountPrecision()
    {
        // test default
        $instance = $this->getInstance();
        self::assertEquals('EUR123.4567', $this->getLine($instance, 7));

        $config = new class extends AbstractConfiguration {
            public function getAmountPrecision(): ?int
            {
                return 2;
            }
        };
        $instance = $this->getInstance($config);
        self::assertEquals('EUR123.46', $this->getLine($instance, 7));

        $config = new class extends AbstractConfiguration {
            public function getAmountPrecision(): ?int
            {
                return 1;
            }
        };
        $instance = $this->getInstance($config);
        self::assertEquals('EUR123.5', $this->getLine($instance, 7));

        $config = new class extends AbstractConfiguration {
            public function getAmountPrecision(): ?int
            {
                return 5;
            }
        };
        $instance = $this->getInstance($config);
        self::assertEquals('EUR123.45670', $this->getLine($instance, 7));

        $config = new class extends AbstractConfiguration {
            public function getAmountPrecision(): ?int
            {
                return null;
            }
        };
        $instance = $this->getInstance($config);
        self::assertEquals('EUR123.4567', $this->getLine($instance, 7));
    }

    public function testGetDueDateHandler()
    {
        // test default
        $instance = $this->getInstance();
        try {
            $instance->getDueDate();
            $this->fail('Expected ' . UnsupportedMethodException::class);
        } catch (UnsupportedMethodException $e) {
        }
        try {
            $instance->setDueDate(new DateTimeImmutable());
            $this->fail('Expected ' . UnsupportedMethodException::class);
        } catch (UnsupportedMethodException $e) {
        }

        $dueDateHandler = new class implements DueDateHandlerInterface {
            /**
             * @var DateTimeInterface
             */
            private $dueDate = null;

            public function setDueDate(DateTimeInterface $dueDate): void
            {
                $this->dueDate = $dueDate;
            }

            public function getDueDate(): DateTimeInterface
            {
                return $this->dueDate ?? new DateTimeImmutable();
            }
        };
        $config = new class($dueDateHandler) extends AbstractConfiguration {
            /**
             * @var DueDateHandlerInterface
             */
            private $dueDateHandler;

            public function __construct(DueDateHandlerInterface $dueDateHandler)
            {
                $this->dueDateHandler = $dueDateHandler;
            }

            public function getDueDateHandler(): ?DueDateHandlerInterface
            {
                return $this->dueDateHandler;
            }

            public function getCustomData(): iterable
            {
                yield $this->dueDateHandler->getDueDate()->format('Ymd');
            }
        };
        $instance = $this->getInstance($config);
        $instance->setDueDate(new DateTimeImmutable('2025-01-01 12:00:00'));
        self::assertEquals('2025-01-01 12:00:00', $instance->getDueDate()->format('Y-m-d H:i:s'));
        self::assertEquals('20250101', $this->getLine($instance, 11));
    }

    private function getInstance(AbstractConfiguration $configuration = null): QrPayment
    {
        return (new QrPayment(new CzechIbanAdapter('1325090010', '3030'), $configuration))
            ->setAmount(123.4567)
            ->setBeneficiaryName('Random Dude');
    }

    private function getLine(QrPayment $payment, int $line): ?string
    {
        $lines = $this->getLines($payment);
        if (!isset($lines[$line])) {
            return null;
        }

        return $lines[$line];
    }

    private function getLines(QrPayment $payment): array
    {
        $result = $payment->getQrString();
        return explode("\n", $result);
    }
}
