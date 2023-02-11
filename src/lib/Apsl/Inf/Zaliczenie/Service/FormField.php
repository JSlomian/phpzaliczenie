<?php

namespace Apsl\Inf\Zaliczenie\Service;

abstract class FormField
{
    protected array $errors = [];
    protected bool $isValid;
    protected array $fieldData;

    public abstract function getHtml(): string;

    public abstract function validate(): bool;

    public function setData(array $data): void
    {

    }

    public function isValid(): bool
    {
        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setLabel(string $label): string
    {

    }

    public function getValue(): string|array
    {
//
    }

}