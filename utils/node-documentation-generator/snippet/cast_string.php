<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use PhpParser\Node\Expr\Cast\String_;
use PhpParser\Node\Expr\Variable;
$expr = new \PhpParser\Node\Expr\Variable('variableName');
return new \PhpParser\Node\Expr\Cast\String_($expr);
