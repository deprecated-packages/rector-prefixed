<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use PhpParser\Node\Expr\Cast\String_;
use PhpParser\Node\Expr\Variable;
$expr = new \PhpParser\Node\Expr\Variable('variableName');
return new \PhpParser\Node\Expr\Cast\String_($expr);
