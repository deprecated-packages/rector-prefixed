<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
$classMethod = new \PhpParser\Node\Stmt\ClassMethod('methodName');
$classMethod->flags = \PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC;
$variable = new \PhpParser\Node\Expr\Variable('some');
$number = new \PhpParser\Node\Scalar\LNumber(10000);
$assign = new \PhpParser\Node\Expr\Assign($variable, $number);
$classMethod->stmts[] = new \PhpParser\Node\Stmt\Expression($assign);
return $classMethod;
