<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoperabd03f0baf05\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoperabd03f0baf05\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
