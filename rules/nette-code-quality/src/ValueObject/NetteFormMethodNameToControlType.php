<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoper006a73f0e455\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoper006a73f0e455\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
