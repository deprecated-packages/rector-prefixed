<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
$variable = new \PhpParser\Node\Expr\Variable('someObject');
return new \PhpParser\Node\Expr\MethodCall($variable, 'methodName');
