<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoper5b8c9e9ebd21\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoper5b8c9e9ebd21\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
