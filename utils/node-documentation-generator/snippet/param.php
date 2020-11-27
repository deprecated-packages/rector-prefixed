<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
$variable = new \PhpParser\Node\Expr\Variable('variableName');
return new \PhpParser\Node\Param($variable);
