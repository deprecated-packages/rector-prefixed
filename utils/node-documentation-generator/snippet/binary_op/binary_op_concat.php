<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Scalar\LNumber;
$left = new \PhpParser\Node\Scalar\LNumber(5);
$right = new \PhpParser\Node\Scalar\LNumber(10);
return new \PhpParser\Node\Expr\BinaryOp\Concat($left, $right);
