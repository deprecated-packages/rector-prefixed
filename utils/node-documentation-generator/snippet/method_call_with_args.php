<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
$variable = new \PhpParser\Node\Expr\Variable('someObject');
$args = [];
$args[] = new \PhpParser\Node\Arg(new \PhpParser\Node\Scalar\String_('yes'));
$args[] = new \PhpParser\Node\Arg(new \PhpParser\Node\Scalar\String_('maybe'));
return new \PhpParser\Node\Expr\MethodCall($variable, 'methodName', $args);
