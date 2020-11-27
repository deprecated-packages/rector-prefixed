<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified;
$fullyQualified = new \PhpParser\Node\Name\FullyQualified('ClassName');
return new \PhpParser\Node\Expr\StaticCall($fullyQualified, 'methodName');
