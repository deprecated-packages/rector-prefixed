<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
$thisVariable = new \PhpParser\Node\Expr\Variable('this');
$propertyFetch = new \PhpParser\Node\Expr\PropertyFetch($thisVariable, 'someProperty');
return new \PhpParser\Node\Expr\MethodCall($propertyFetch, 'methodName');
