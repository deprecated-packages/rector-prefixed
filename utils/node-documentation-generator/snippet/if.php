<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\If_;
$cond = new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name('true'));
return new \PhpParser\Node\Stmt\If_($cond);
