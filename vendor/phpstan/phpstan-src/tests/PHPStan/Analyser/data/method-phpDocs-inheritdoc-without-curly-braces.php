<?php

namespace _PhpScoper006a73f0e455\MethodPhpDocsNamespace;

use _PhpScoper006a73f0e455\SomeNamespace\Amet as Dolor;
use _PhpScoper006a73f0e455\SomeNamespace\Consecteur;
class FooInheritDocChild extends \_PhpScoper006a73f0e455\MethodPhpDocsNamespace\Foo
{
    /**
     * @inheritdoc
     */
    public function doFoo($mixedParameter, $unionTypeParameter, $anotherMixedParameter, $yetAnotherMixedParameter, $integerParameter, $anotherIntegerParameter, $arrayParameterOne, $arrayParameterOther, $objectRelative, $objectFullyQualified, $objectUsed, $nullableInteger, $nullableObject, $selfType, $staticType, $nullType, $barObject, \_PhpScoper006a73f0e455\MethodPhpDocsNamespace\Bar $conflictedObject, \_PhpScoper006a73f0e455\MethodPhpDocsNamespace\Bar $moreSpecifiedObject, $resource, $yetAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherAnotherMixedParameter, $voidParameter, $useWithoutAlias, $true, $false, bool $boolTrue, bool $boolFalse, bool $trueBoolean, $objectWithoutNativeTypehint, object $objectWithNativeTypehint, $parameterWithDefaultValueFalse = \false, $anotherNullableObject = null)
    {
        $parent = new \_PhpScoper006a73f0e455\MethodPhpDocsNamespace\FooParent();
        $differentInstance = new \_PhpScoper006a73f0e455\MethodPhpDocsNamespace\Foo();
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
