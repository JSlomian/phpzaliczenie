<?php

namespace Apsl\Inf\Zaliczenie\Service;

class ChoiceFormField extends FormField
{
    private const RADIO = "radio";
    private const CHECKBOX = "checkbox";

    public function getHtml(): string
    {
        if (!$this->isValid()) {
            return "";
        }
        $formField = "";
        $type = $this->fieldData['type'];
        $name = $this->fieldData['name'];
        $value = $this->fieldData['value'];
        if ($type == self::CHECKBOX) {
            $name .= "[]";
        }
        if (is_array($value)) {
            foreach ($value as $singleValue) {
                $inputValue = $singleValue['input'];
                $id = $this->fieldData['name'] . "_" . $inputValue;
                $formField .= ($this->isFullForm()) ? "<li>" : "";
                $formField .= "<input type=\"$type\" id=\”$id\” name=\”$name\” value=\”$inputValue\”>";
                if (isset($singleValue['label'])) {
                    $label = $singleValue['label'];
                    $formField .= "<label for=\”$id\”>$label</label>";
                }
                $formField .= ($this->isFullForm()) ? "</li>" : "";
            }
        }
        if (is_string($value)) {
            $id = $this->fieldData['name'] . "_" . $this->fieldData['value'];
            $formField .= ($this->isFullForm()) ? "<li>" : "";
            $formField .= "<input type=\"$type\" id=\"$id\" name=\"$name\" value=\"$value\">";
            if (isset($this->fieldData['label'])) {
                $label = $this->fieldData['label'];
                $formField .= "<label for=\"$id\">$label</label>";
            }
            $formField .= ($this->isFullForm()) ? "</li>" : "";
        }
        if ($this->isFullForm()) {
            $formName = $this->fieldData['formName'];
            return "<form><ul>$formName" . $formField . "<li><button type=\"submit\">Wyślij</button></li></ul></form>";
        }
        return $formField;
    }


    public function validate(): bool
    {
        if (empty($this->fieldData)) {
            $this->errors[] = 'Pusta tablica';
        }
        if (!isset($this->fieldData['name'])) {
            $this->errors[] = 'Nazwa musi zostać ustawiona';
        }
        if (!isset($this->fieldData['type'])) {
            $this->errors[] = 'Typ musi zostać ustawiony';
        }
        if (!isset($this->fieldData['value'])) {
            $this->errors[] = 'Wartość musi być ustawiona';
        }
        if (strtolower($this->fieldData['type']) != self::CHECKBOX && strtolower($this->fieldData['type']) != self::RADIO) {
            $this->errors[] = 'Typ może być tylko checkbox albo radio, podano ' . $this->fieldData['type'];
        }
        if (is_string($this->fieldData['name']) && strlen($this->fieldData['name']) < 1) {
            $this->errors[] = 'Nazwa nie może być pusta';
        }
        if (is_array($this->fieldData['value']) && empty($this->fieldData['value'])) {
            $this->errors[] = 'Value nie może być pustą tablicą';
        }
        if (is_string($this->fieldData['value']) && strlen($this->fieldData['value']) < 1) {
            $this->errors[] = 'Value nie może być pustym stringiem';
        }
        if ($this->fieldData['type'] == self::RADIO && is_array($this->fieldData['value']) && count($this->fieldData['value']) > 2) {
            $this->errors[] = 'Radio nie może mieć więcej niż 2 opcji';
        }
        if (empty($this->errors)) {
            return $this->isValid = true;
        }
        return $this->isValid;
    }
}