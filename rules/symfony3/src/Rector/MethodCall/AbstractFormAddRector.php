<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Symfony3\FormHelper\FormTypeStringToTypeProvider;
abstract class AbstractFormAddRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const FORM_TYPES = ['_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\FormBuilderInterface', '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\FormInterface'];
    /**
     * @var FormTypeStringToTypeProvider
     */
    protected $formTypeStringToTypeProvider;
    /**
     * @required
     */
    public function autowireAbstractFormAddRector(\_PhpScoperb75b35f52b74\Rector\Symfony3\FormHelper\FormTypeStringToTypeProvider $formTypeStringToTypeProvider) : void
    {
        $this->formTypeStringToTypeProvider = $formTypeStringToTypeProvider;
    }
    protected function isFormAddMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->isObjectTypes($methodCall->var, self::FORM_TYPES)) {
            return \false;
        }
        if (!$this->isName($methodCall->name, 'add')) {
            return \false;
        }
        // just one argument
        if (!isset($methodCall->args[1])) {
            return \false;
        }
        return $methodCall->args[1]->value !== null;
    }
    protected function matchOptionsArray(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_
    {
        if (!isset($methodCall->args[2])) {
            return null;
        }
        $optionsArray = $methodCall->args[2]->value;
        if (!$optionsArray instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
            return null;
        }
        return $optionsArray;
    }
    protected function isCollectionType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $typeValue = $methodCall->args[1]->value;
        if ($typeValue instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch && $this->isName($typeValue->class, '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CollectionType')) {
            return \true;
        }
        return $this->isValue($typeValue, 'collection');
    }
}
