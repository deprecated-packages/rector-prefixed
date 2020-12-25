<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoper8b9c402c5f32\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoper8b9c402c5f32\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
