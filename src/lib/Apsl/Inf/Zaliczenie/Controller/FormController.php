<?php

namespace Apsl\Inf\Zaliczenie\Controller;

use Apsl\Controller\BasePage;
use Apsl\Inf\Zaliczenie\Service\ChoiceFormField;

class FormController extends BasePage
{
    protected function doHandle(): void
    {
        $singleInputRadioData = [
            "type" => "radio",
            "label" => 'pojedyńcze radio',
            "value" => 'jakieś value',
            "name" => 'singleInputRadio'
        ];
        $singleInput = new ChoiceFormField();
        $singleInput->setData($singleInputRadioData);
        $singleInput->validate();
        $fullFormCheckbox = [
            'type' => 'checkbox',
            'name' => 'Lista checkboxów',
            'value' => [
                ['input' => 'asd', 'label' => 'jedyneczka'],
                ['input' => 'das', 'label' => 'costam'],
                ['input' => 'qweqwe', 'label' => 'trzeci'],
            ],
            'formName' => 'checkboxy'
        ];
        $fullForm = new ChoiceFormField();
        $fullForm->setData($fullFormCheckbox);
        $fullForm->validate();
        $body = [
            'inputs' => [
                $singleInput->getHtml(),
                $fullForm->getHtml()
            ],
            'errors' => array_merge($singleInput->getErrors(), $fullForm->getErrors())

        ];
        $this->response->setBody($this->useTemplate('templates/form.html.php', $body));
    }
}