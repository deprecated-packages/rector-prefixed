<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\Button',
        'addImage' => 'RectorPrefix2020DecSat\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => 'RectorPrefix2020DecSat\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
