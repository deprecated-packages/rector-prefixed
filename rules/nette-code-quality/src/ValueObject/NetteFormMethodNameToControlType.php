<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteCodeQuality\ValueObject;

final class NetteFormMethodNameToControlType
{
    /**
     * @var string[]
     */
    public const METHOD_NAME_TO_CONTROL_TYPE = [
        'addText' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\TextInput',
        'addPassword' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\TextInput',
        'addEmail' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\TextInput',
        'addInteger' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\TextInput',
        'addUpload' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\UploadControl',
        'addMultiUpload' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\UploadControl',
        'addTextArea' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\TextArea',
        'addHidden' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\HiddenField',
        'addCheckbox' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\Checkbox',
        'addRadioList' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\RadioList',
        'addCheckboxList' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\CheckboxList',
        'addSelect' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\SelectBox',
        'addMultiSelect' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\MultiSelectBox',
        'addSubmit' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\SubmitButton',
        'addButton' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\Button',
        'addImage' => '_PhpScoper2a4e7ab1ecbc\\Nette\\Forms\\Controls\\ImageButton',
        // custom
        'addJSelect' => '_PhpScoper2a4e7ab1ecbc\\DependentSelectBox\\JsonDependentSelectBox',
    ];
}
