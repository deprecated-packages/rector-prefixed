<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\Variable;
$variable = new \PhpParser\Node\Expr\Variable('isEligible');
return new \PhpParser\Node\Expr\BooleanNot($variable);
