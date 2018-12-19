<?php

namespace rikudou\EuQrPayment\Helper;

trait ToStringIban
{
    public function __toString()
    {
        if (!method_exists($this, 'getIban')) {
            return '';
        }
        try {
            return $this->getIban();
        } catch (\Throwable $exception) {
            return '';
        }
    }
}
