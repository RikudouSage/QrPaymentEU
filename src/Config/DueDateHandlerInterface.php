<?php

namespace rikudou\EuQrPayment\Config;

use DateTimeInterface;

interface DueDateHandlerInterface
{
    public function setDueDate(DateTimeInterface $dueDate): void;

    public function getDueDate(): DateTimeInterface;
}
