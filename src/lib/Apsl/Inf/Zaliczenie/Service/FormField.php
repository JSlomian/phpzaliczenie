<?php

namespace Apsl\Inf\Zaliczenie\Service;

abstract class FormField
{
    protected array $errors = [];
    protected bool $isValid = false;
    protected array $fieldData;

    public abstract function getHtml(): string;

    public abstract function validate(): bool;

    public function setData(array $data): void
    {
        $this->fieldData = $data;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function isFullForm(): bool
    {
        return isset($this->fieldData['formName']) == true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setLabel(string $label): string
    {
        return $this->fieldData['label'] = $label; // single input only, could be for formName maybe ?
    }

    public function getValue(): string|array
    {
        return $this->fieldData['value'];
    }

}