<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\Button',
        'addImage' => 'RectorPrefix20201227\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => 'RectorPrefix20201227\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
