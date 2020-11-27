<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoperbd5d0c5f7638\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoperbd5d0c5f7638\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
