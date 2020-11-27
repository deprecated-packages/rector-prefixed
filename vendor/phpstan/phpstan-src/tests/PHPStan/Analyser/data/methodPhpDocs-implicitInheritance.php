<?php

namespace _PhpScoperbd5d0c5f7638\MethodPhpDocsNamespace;

use _PhpScoperbd5d0c5f7638\SomeNamespace\Amet as Dolor;
use _PhpScoperbd5d0c5f7638\SomeNamespace\Consecteur;
class FooPhpDocsImplicitInheritanceChild extends \_PhpScoperbd5d0c5f7638\MethodPhpDocsNamespace\Foo
{
    public function doFoo($mixedParameter, $unionTypeParameter, $anotherMixedParameter, $yetAnotherMixedParameter, $integerParameter, $anotherIntegerParameter, $arrayParameterOne, $arrayParameterOther, $objectRelative, $objectFullyQualified, $objectUsed, $nullableInteger, $nullableObject, $selfType, $staticType, $nullType, $barObject, \_PhpScoperbd5d0c5f7638\MethodPhpDocsNamespace\Bar $conflictedObject, \_PhpScoperbd5d0c5f7638\MethodPhpDocsNamespace\Bar $moreSpecifiedObject, $resource, $yetAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherAnotherMixedParameter, $voidParameter, $useWithoutAlias, $true, $false, bool $boolTrue, bool $boolFalse, bool $trueBoolean, $objectWithoutNativeTypehint, object $objectWithNativeTypehint, $parameterWithDefaultValueFalse = \false, $anotherNullableObject = null)
    {
        $parent = new \_PhpScoperbd5d0c5f7638\MethodPhpDocsNamespace\FooParent();
        $differentInstance = new \_PhpScoperbd5d0c5f7638\MethodPhpDocsNamespace\Foo();
        /** @var self $inlineSelf */
        $inlineSelf = doFoo();
        /** @var Bar $inlineBar */
        $inlineBar = doFoo();
        foreach ($moreSpecifiedObject->doFluentUnionIterable() as $fluentUnionIterableBaz) {
            die;
        }
    }
    public function returnsStringArray() : array
    {
    }
    private function privateMethodWithPhpDoc()
    {
    }
}
