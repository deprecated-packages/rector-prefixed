<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Static_;
use PhpParser\Node\Stmt\StaticVar;
$staticVars = [new \PhpParser\Node\Stmt\StaticVar(new \PhpParser\Node\Expr\Variable('static'))];
return new \PhpParser\Node\Stmt\Static_($staticVars);
