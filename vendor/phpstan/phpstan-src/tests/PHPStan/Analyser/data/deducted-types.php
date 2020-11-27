<?php

namespace _PhpScoper006a73f0e455\TypesNamespaceDeductedTypes;

use _PhpScoper006a73f0e455\TypesNamespaceFunctions;
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
        $loremObjectLiteral = new \_PhpScoper006a73f0e455\TypesNamespaceDeductedTypes\Lorem();
        $mixedObjectLiteral = new $class();
        $newStatic = new static();
        $arrayLiteral = [];
        $stringFromFunction = \_PhpScoper006a73f0e455\TypesNamespaceFunctions\stringFunction();
        $fooObjectFromFunction = \_PhpScoper006a73f0e455\TypesNamespaceFunctions\objectFunction();
        $mixedFromFunction = \_PhpScoper006a73f0e455\TypesNamespaceFunctions\unknownTypeFunction();
        $foo = new self();
        die;
    }
}
