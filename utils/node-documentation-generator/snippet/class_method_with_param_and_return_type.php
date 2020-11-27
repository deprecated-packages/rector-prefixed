<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
$classMethod = new \PhpParser\Node\Stmt\ClassMethod('methodName');
$classMethod->flags = \PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE;
$param = new \PhpParser\Node\Param(new \PhpParser\Node\Expr\Variable('paramName'));
$classMethod->params = [$param];
$classMethod->returnType = new \PhpParser\Node\Identifier('string');
return $classMethod;
