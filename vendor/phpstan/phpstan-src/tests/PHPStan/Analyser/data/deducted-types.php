<?php

namespace _PhpScoper26e51eeacccf\TypesNamespaceDeductedTypes;

use _PhpScoper26e51eeacccf\TypesNamespaceFunctions;
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
        $loremObjectLiteral = new \_PhpScoper26e51eeacccf\TypesNamespaceDeductedTypes\Lorem();
        $mixedObjectLiteral = new $class();
        $newStatic = new static();
        $arrayLiteral = [];
        $stringFromFunction = \_PhpScoper26e51eeacccf\TypesNamespaceFunctions\stringFunction();
        $fooObjectFromFunction = \_PhpScoper26e51eeacccf\TypesNamespaceFunctions\objectFunction();
        $mixedFromFunction = \_PhpScoper26e51eeacccf\TypesNamespaceFunctions\unknownTypeFunction();
        $foo = new self();
        die;
    }
}
