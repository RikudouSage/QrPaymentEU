<?php

namespace rikudou\EuQrPayment\Config;

interface ConfigurationInterface
{
    /**
     * The standard version like 001 or 002
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Additional custom data to be appended at the generated string
     *
     * @return iterable<string>
     */
    public function getCustomData(): iterable;

    /**
     * The precision to be applied to the amount
     *
     * @return int|null
     */
    public function getAmountPrecision(): ?int;

    /**
     * The standard does not support setting due date, you can use this to set your own non-standard implementation
     *
     * @return DueDateHandlerInterface|null
     */
    public function getDueDateHandler(): ?DueDateHandlerInterface;
}
