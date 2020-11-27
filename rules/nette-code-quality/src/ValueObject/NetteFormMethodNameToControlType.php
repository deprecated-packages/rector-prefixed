<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScopera143bcca66cb\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScopera143bcca66cb\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
