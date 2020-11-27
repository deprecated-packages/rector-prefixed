<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
$classMethod = new \PhpParser\Node\Stmt\ClassMethod('methodName');
$classMethod->flags = \PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC;
return $classMethod;
