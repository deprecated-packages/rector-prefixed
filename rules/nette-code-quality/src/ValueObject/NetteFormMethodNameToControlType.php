<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoperf18a0c41e2d2\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoperf18a0c41e2d2\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
