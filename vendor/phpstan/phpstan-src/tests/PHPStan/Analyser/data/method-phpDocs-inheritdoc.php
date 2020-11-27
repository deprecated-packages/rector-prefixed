<?php

namespace _PhpScopera143bcca66cb\MethodPhpDocsNamespace;

use _PhpScopera143bcca66cb\SomeNamespace\Amet as Dolor;
use _PhpScopera143bcca66cb\SomeNamespace\Consecteur;
class FooInheritDocChild extends \_PhpScopera143bcca66cb\MethodPhpDocsNamespace\Foo
{
    /**
     * {@inheritdoc}
     */
    public function doFoo($mixedParameter, $unionTypeParameter, $anotherMixedParameter, $yetAnotherMixedParameter, $integerParameter, $anotherIntegerParameter, $arrayParameterOne, $arrayParameterOther, $objectRelative, $objectFullyQualified, $objectUsed, $nullableInteger, $nullableObject, $selfType, $staticType, $nullType, $barObject, \_PhpScopera143bcca66cb\MethodPhpDocsNamespace\Bar $conflictedObject, \_PhpScopera143bcca66cb\MethodPhpDocsNamespace\Bar $moreSpecifiedObject, $resource, $yetAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherAnotherMixedParameter, $voidParameter, $useWithoutAlias, $true, $false, bool $boolTrue, bool $boolFalse, bool $trueBoolean, $objectWithoutNativeTypehint, object $objectWithNativeTypehint, $parameterWithDefaultValueFalse = \false, $anotherNullableObject = null)
    {
        $parent = new \_PhpScopera143bcca66cb\MethodPhpDocsNamespace\FooParent();
        $differentInstance = new \_PhpScopera143bcca66cb\MethodPhpDocsNamespace\Foo();
        /** @var self $inlineSelf */
        $inlineSelf = doFoo();
        /** @var Bar $inlineBar */
        $inlineBar = doFoo();
        foreach ($moreSpecifiedObject->doFluentUnionIterable() as $fluentUnionIterableBaz) {
            die;
        }
    }
    /**
     * {@inheritdoc}
     */
    private function privateMethodWithPhpDoc()
    {
    }
}
