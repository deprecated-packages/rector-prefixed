<?php

declare (strict_types=1);
namespace Rector\Symfony3\Rector\MethodCall;

use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use Rector\Core\Rector\AbstractRector;
use Rector\Symfony3\FormHelper\FormTypeStringToTypeProvider;
use RectorPrefix20210220\Symfony\Component\Form\FormBuilderInterface;
use RectorPrefix20210220\Symfony\Component\Form\FormInterface;
abstract class AbstractFormAddRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var class-string<FormBuilderInterface>[]|class-string<FormInterface>[]
     */
    private const FORM_TYPES = ['Symfony\\Component\\Form\\FormBuilderInterface', 'Symfony\\Component\\Form\\FormInterface'];
    /**
     * @var FormTypeStringToTypeProvider
     */
    protected $formTypeStringToTypeProvider;
    /**
     * @required
     */
    public function autowireAbstractFormAddRector(\Rector\Symfony3\FormHelper\FormTypeStringToTypeProvider $formTypeStringToTypeProvider) : void
    {
        $this->formTypeStringToTypeProvider = $formTypeStringToTypeProvider;
    }
    protected function isFormAddMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : bool
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
    protected function matchOptionsArray(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node\Expr\Array_
    {
        if (!isset($methodCall->args[2])) {
            return null;
        }
        $optionsArray = $methodCall->args[2]->value;
        if (!$optionsArray instanceof \PhpParser\Node\Expr\Array_) {
            return null;
        }
        return $optionsArray;
    }
    protected function isCollectionType(\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $typeValue = $methodCall->args[1]->value;
        if ($typeValue instanceof \PhpParser\Node\Expr\ClassConstFetch && $this->isName($typeValue->class, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\CollectionType')) {
            return \true;
        }
        return $this->valueResolver->isValue($typeValue, 'collection');
    }
}
