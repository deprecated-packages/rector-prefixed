<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\Case_;
use PhpParser\Node\Stmt\Switch_;
$cond = new \PhpParser\Node\Expr\Variable('variableName');
$cases = [new \PhpParser\Node\Stmt\Case_(new \PhpParser\Node\Scalar\LNumber(1))];
return new \PhpParser\Node\Stmt\Switch_($cond, $cases);
