<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Foreach_;
$foreachedVariable = new \PhpParser\Node\Expr\Variable('foreachedVariableName');
$asVariable = new \PhpParser\Node\Expr\Variable('asVariable');
return new \PhpParser\Node\Stmt\Foreach_($foreachedVariable, $asVariable);
