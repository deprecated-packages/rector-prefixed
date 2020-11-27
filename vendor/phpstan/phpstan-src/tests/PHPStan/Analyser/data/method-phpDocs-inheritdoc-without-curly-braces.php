<?php

namespace _PhpScoper88fe6e0ad041\MethodPhpDocsNamespace;

use _PhpScoper88fe6e0ad041\SomeNamespace\Amet as Dolor;
use _PhpScoper88fe6e0ad041\SomeNamespace\Consecteur;
class FooInheritDocChild extends \_PhpScoper88fe6e0ad041\MethodPhpDocsNamespace\Foo
{
    /**
     * @inheritdoc
     */
    public function doFoo($mixedParameter, $unionTypeParameter, $anotherMixedParameter, $yetAnotherMixedParameter, $integerParameter, $anotherIntegerParameter, $arrayParameterOne, $arrayParameterOther, $objectRelative, $objectFullyQualified, $objectUsed, $nullableInteger, $nullableObject, $selfType, $staticType, $nullType, $barObject, \_PhpScoper88fe6e0ad041\MethodPhpDocsNamespace\Bar $conflictedObject, \_PhpScoper88fe6e0ad041\MethodPhpDocsNamespace\Bar $moreSpecifiedObject, $resource, $yetAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherAnotherMixedParameter, $voidParameter, $useWithoutAlias, $true, $false, bool $boolTrue, bool $boolFalse, bool $trueBoolean, $objectWithoutNativeTypehint, object $objectWithNativeTypehint, $parameterWithDefaultValueFalse = \false, $anotherNullableObject = null)
    {
        $parent = new \_PhpScoper88fe6e0ad041\MethodPhpDocsNamespace\FooParent();
        $differentInstance = new \_PhpScoper88fe6e0ad041\MethodPhpDocsNamespace\Foo();
        /** @var self $inlineSelf */
        $inlineSelf = doFoo();
        /** @var Bar $inlineBar */
        $inlineBar = doFoo();
        foreach ($moreSpecifiedObject->doFluentUnionIterable() as $fluentUnionIterableBaz) {
            die;
        }
    }
    /**
     * @inheritdoc
     */
    private function privateMethodWithPhpDoc()
    {
    }
}
