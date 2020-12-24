<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony3\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Symfony3\FormHelper\FormTypeStringToTypeProvider;
abstract class AbstractFormAddRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const FORM_TYPES = ['_PhpScoper0a6b37af0871\\Symfony\\Component\\Form\\FormBuilderInterface', '_PhpScoper0a6b37af0871\\Symfony\\Component\\Form\\FormInterface'];
    /**
     * @var FormTypeStringToTypeProvider
     */
    protected $formTypeStringToTypeProvider;
    /**
     * @required
     */
    public function autowireAbstractFormAddRector(\_PhpScoper0a6b37af0871\Rector\Symfony3\FormHelper\FormTypeStringToTypeProvider $formTypeStringToTypeProvider) : void
    {
        $this->formTypeStringToTypeProvider = $formTypeStringToTypeProvider;
    }
    protected function isFormAddMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : bool
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
    protected function matchOptionsArray(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_
    {
        if (!isset($methodCall->args[2])) {
            return null;
        }
        $optionsArray = $methodCall->args[2]->value;
        if (!$optionsArray instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
            return null;
        }
        return $optionsArray;
    }
    protected function isCollectionType(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $typeValue = $methodCall->args[1]->value;
        if ($typeValue instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch && $this->isName($typeValue->class, '_PhpScoper0a6b37af0871\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CollectionType')) {
            return \true;
        }
        return $this->isValue($typeValue, 'collection');
    }
}
