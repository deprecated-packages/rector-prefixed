<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Name\FullyQualified;
$class = new \PhpParser\Node\Name\FullyQualified('SomeClassName');
return new \PhpParser\Node\Expr\ClassConstFetch($class, 'SOME_CONSTANT');