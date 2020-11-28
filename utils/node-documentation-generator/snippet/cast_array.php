<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use PhpParser\Node\Expr\Cast\Array_;
use PhpParser\Node\Expr\Variable;
$expr = new \PhpParser\Node\Expr\Variable('variableName');
return new \PhpParser\Node\Expr\Cast\Array_($expr);
