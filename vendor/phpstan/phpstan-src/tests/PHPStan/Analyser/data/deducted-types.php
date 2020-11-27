<?php

namespace _PhpScopera143bcca66cb\TypesNamespaceDeductedTypes;

use _PhpScopera143bcca66cb\TypesNamespaceFunctions;
class Foo
{
    const INTEGER_CONSTANT = 1;
    const FLOAT_CONSTANT = 1.0;
    const STRING_CONSTANT = 'foo';
    const ARRAY_CONSTANT = [];
    const BOOLEAN_CONSTANT = \true;
    const NULL_CONSTANT = null;
    public function doFoo()
    {
        $integerLiteral = 1;
        $booleanLiteral = \true;
        $anotherBooleanLiteral = \false;
        $stringLiteral = 'foo';
        $floatLiteral = 1.0;
        $floatAssignedByRef =& $floatLiteral;
        $nullLiteral = null;
        $loremObjectLiteral = new \_PhpScopera143bcca66cb\TypesNamespaceDeductedTypes\Lorem();
        $mixedObjectLiteral = new $class();
        $newStatic = new static();
        $arrayLiteral = [];
        $stringFromFunction = \_PhpScopera143bcca66cb\TypesNamespaceFunctions\stringFunction();
        $fooObjectFromFunction = \_PhpScopera143bcca66cb\TypesNamespaceFunctions\objectFunction();
        $mixedFromFunction = \_PhpScopera143bcca66cb\TypesNamespaceFunctions\unknownTypeFunction();
        $foo = new self();
        die;
    }
}
