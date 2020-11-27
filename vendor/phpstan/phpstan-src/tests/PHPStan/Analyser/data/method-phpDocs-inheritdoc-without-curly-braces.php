<?php

namespace _PhpScoper26e51eeacccf\MethodPhpDocsNamespace;

use _PhpScoper26e51eeacccf\SomeNamespace\Amet as Dolor;
use _PhpScoper26e51eeacccf\SomeNamespace\Consecteur;
class FooInheritDocChild extends \_PhpScoper26e51eeacccf\MethodPhpDocsNamespace\Foo
{
    /**
     * @inheritdoc
     */
    public function doFoo($mixedParameter, $unionTypeParameter, $anotherMixedParameter, $yetAnotherMixedParameter, $integerParameter, $anotherIntegerParameter, $arrayParameterOne, $arrayParameterOther, $objectRelative, $objectFullyQualified, $objectUsed, $nullableInteger, $nullableObject, $selfType, $staticType, $nullType, $barObject, \_PhpScoper26e51eeacccf\MethodPhpDocsNamespace\Bar $conflictedObject, \_PhpScoper26e51eeacccf\MethodPhpDocsNamespace\Bar $moreSpecifiedObject, $resource, $yetAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherAnotherMixedParameter, $voidParameter, $useWithoutAlias, $true, $false, bool $boolTrue, bool $boolFalse, bool $trueBoolean, $objectWithoutNativeTypehint, object $objectWithNativeTypehint, $parameterWithDefaultValueFalse = \false, $anotherNullableObject = null)
    {
        $parent = new \_PhpScoper26e51eeacccf\MethodPhpDocsNamespace\FooParent();
        $differentInstance = new \_PhpScoper26e51eeacccf\MethodPhpDocsNamespace\Foo();
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
