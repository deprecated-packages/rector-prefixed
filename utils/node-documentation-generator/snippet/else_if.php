<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ElseIf_;
use PhpParser\Node\Stmt\Return_;
$name = new \PhpParser\Node\Name('true');
$constFetch = new \PhpParser\Node\Expr\ConstFetch($name);
$stmt = new \PhpParser\Node\Stmt\Return_();
return new \PhpParser\Node\Stmt\ElseIf_($constFetch, [$stmt]);
