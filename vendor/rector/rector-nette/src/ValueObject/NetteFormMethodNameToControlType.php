<?php

declare (strict_types=1);
namespace Rector\Nette\ValueObject;

use RectorPrefix20210321\Nette\Forms\Controls\BaseControl;
final class NetteFormMethodNameToControlType
{
    /**
     * @var array<string, class-string<BaseControl>>
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\Button',
        'addImage' => 'RectorPrefix20210321\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => 'RectorPrefix20210321\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
