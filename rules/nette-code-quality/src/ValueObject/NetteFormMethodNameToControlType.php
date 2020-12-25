<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoperfce0de0de1ce\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoperfce0de0de1ce\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
