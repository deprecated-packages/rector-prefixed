<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoper26e51eeacccf\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoper26e51eeacccf\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
