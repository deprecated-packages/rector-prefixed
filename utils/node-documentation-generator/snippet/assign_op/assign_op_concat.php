<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use PhpParser\Node\Expr\AssignOp\Concat;
use PhpParser\Node\Scalar\LNumber;
$left = new \PhpParser\Node\Scalar\LNumber(5);
$right = new \PhpParser\Node\Scalar\LNumber(10);
return new \PhpParser\Node\Expr\AssignOp\Concat($left, $right);