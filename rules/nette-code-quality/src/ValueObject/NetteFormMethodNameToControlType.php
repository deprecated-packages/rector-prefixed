<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoper17db12703726\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoper17db12703726\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
