<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoperbf340cb0be9d\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoperbf340cb0be9d\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
