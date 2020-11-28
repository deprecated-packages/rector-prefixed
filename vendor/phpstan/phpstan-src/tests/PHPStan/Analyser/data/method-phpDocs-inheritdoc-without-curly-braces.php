<?php

namespace _PhpScoperabd03f0baf05\MethodPhpDocsNamespace;

use _PhpScoperabd03f0baf05\SomeNamespace\Amet as Dolor;
use _PhpScoperabd03f0baf05\SomeNamespace\Consecteur;
class FooInheritDocChild extends \_PhpScoperabd03f0baf05\MethodPhpDocsNamespace\Foo
{
    /**
     * @inheritdoc
     */
    public function doFoo($mixedParameter, $unionTypeParameter, $anotherMixedParameter, $yetAnotherMixedParameter, $integerParameter, $anotherIntegerParameter, $arrayParameterOne, $arrayParameterOther, $objectRelative, $objectFullyQualified, $objectUsed, $nullableInteger, $nullableObject, $selfType, $staticType, $nullType, $barObject, \_PhpScoperabd03f0baf05\MethodPhpDocsNamespace\Bar $conflictedObject, \_PhpScoperabd03f0baf05\MethodPhpDocsNamespace\Bar $moreSpecifiedObject, $resource, $yetAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherMixedParameter, $yetAnotherAnotherAnotherAnotherMixedParameter, $voidParameter, $useWithoutAlias, $true, $false, bool $boolTrue, bool $boolFalse, bool $trueBoolean, $objectWithoutNativeTypehint, object $objectWithNativeTypehint, $parameterWithDefaultValueFalse = \false, $anotherNullableObject = null)
    {
        $parent = new \_PhpScoperabd03f0baf05\MethodPhpDocsNamespace\FooParent();
        $differentInstance = new \_PhpScoperabd03f0baf05\MethodPhpDocsNamespace\Foo();
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
