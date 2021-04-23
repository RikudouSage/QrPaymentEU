<?php

namespace rikudou\EuQrPayment\Config;

abstract class AbstractConfiguration implements ConfigurationInterface
{
    public function getVersion(): string
    {
        return '002';
    }

    public function getCustomData(): iterable
    {
        return [];
    }

    public function getAmountPrecision(): ?int
    {
        return null;
    }

    public function getDueDateHandler(): ?DueDateHandlerInterface
    {
        return null;
    }
}
