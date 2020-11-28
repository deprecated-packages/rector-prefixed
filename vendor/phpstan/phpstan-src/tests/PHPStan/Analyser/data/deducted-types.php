<?php

namespace _PhpScoperabd03f0baf05\TypesNamespaceDeductedTypes;

use _PhpScoperabd03f0baf05\TypesNamespaceFunctions;
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
        $loremObjectLiteral = new \_PhpScoperabd03f0baf05\TypesNamespaceDeductedTypes\Lorem();
        $mixedObjectLiteral = new $class();
        $newStatic = new static();
        $arrayLiteral = [];
        $stringFromFunction = \_PhpScoperabd03f0baf05\TypesNamespaceFunctions\stringFunction();
        $fooObjectFromFunction = \_PhpScoperabd03f0baf05\TypesNamespaceFunctions\objectFunction();
        $mixedFromFunction = \_PhpScoperabd03f0baf05\TypesNamespaceFunctions\unknownTypeFunction();
        $foo = new self();
        die;
    }
}
