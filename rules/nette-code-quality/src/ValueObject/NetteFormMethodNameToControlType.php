<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoperb75b35f52b74\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
