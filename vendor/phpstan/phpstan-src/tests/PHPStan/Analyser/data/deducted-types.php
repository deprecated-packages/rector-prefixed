<?php

namespace _PhpScoperbd5d0c5f7638\TypesNamespaceDeductedTypes;

use _PhpScoperbd5d0c5f7638\TypesNamespaceFunctions;
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
        $loremObjectLiteral = new \_PhpScoperbd5d0c5f7638\TypesNamespaceDeductedTypes\Lorem();
        $mixedObjectLiteral = new $class();
        $newStatic = new static();
        $arrayLiteral = [];
        $stringFromFunction = \_PhpScoperbd5d0c5f7638\TypesNamespaceFunctions\stringFunction();
        $fooObjectFromFunction = \_PhpScoperbd5d0c5f7638\TypesNamespaceFunctions\objectFunction();
        $mixedFromFunction = \_PhpScoperbd5d0c5f7638\TypesNamespaceFunctions\unknownTypeFunction();
        $foo = new self();
        die;
    }
}
