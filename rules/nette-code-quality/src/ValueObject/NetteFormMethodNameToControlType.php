<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoper88fe6e0ad041\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoper88fe6e0ad041\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
