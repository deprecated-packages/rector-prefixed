<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScopere8e811afab72\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScopere8e811afab72\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
