<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoper50d83356d739\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoper50d83356d739\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
