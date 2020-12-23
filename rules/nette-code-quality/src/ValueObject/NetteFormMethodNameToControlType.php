<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoper0a2ac50786fa\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoper0a2ac50786fa\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
