<?php

namespace rikudou\EuQrPayment\Iban\Validator;

class CompoundValidator implements ValidatorInterface
{
    /**
     * @var ValidatorInterface[]
     */
    private $validators;

    public function __construct(ValidatorInterface ...$validators)
    {
        if (!count($validators)) {
            throw new \InvalidArgumentException('At least one validator is required');
        }
        $this->validators = $validators;
    }

    public function isValid(): bool
    {
        $isValid = true;
        foreach ($this->validators as $validator) {
            $isValid = $isValid && $validator->isValid();
        }

        return $isValid;
    }
}
