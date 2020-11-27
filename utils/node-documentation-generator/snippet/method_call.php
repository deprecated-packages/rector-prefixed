<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
$variable = new \PhpParser\Node\Expr\Variable('someObject');
return new \PhpParser\Node\Expr\MethodCall($variable, 'methodName');
