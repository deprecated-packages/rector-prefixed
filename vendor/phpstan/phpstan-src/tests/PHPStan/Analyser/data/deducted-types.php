<?php

namespace _PhpScoper88fe6e0ad041\TypesNamespaceDeductedTypes;

use _PhpScoper88fe6e0ad041\TypesNamespaceFunctions;
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
        $loremObjectLiteral = new \_PhpScoper88fe6e0ad041\TypesNamespaceDeductedTypes\Lorem();
        $mixedObjectLiteral = new $class();
        $newStatic = new static();
        $arrayLiteral = [];
        $stringFromFunction = \_PhpScoper88fe6e0ad041\TypesNamespaceFunctions\stringFunction();
        $fooObjectFromFunction = \_PhpScoper88fe6e0ad041\TypesNamespaceFunctions\objectFunction();
        $mixedFromFunction = \_PhpScoper88fe6e0ad041\TypesNamespaceFunctions\unknownTypeFunction();
        $foo = new self();
        die;
    }
}
