<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\Echo_;
use PhpParser\Node\Stmt\Finally_;
use PhpParser\Node\Stmt\TryCatch;
$echo = new \PhpParser\Node\Stmt\Echo_([new \PhpParser\Node\Scalar\String_('one')]);
$tryStmts = [$echo];
$echo2 = new \PhpParser\Node\Stmt\Echo_([new \PhpParser\Node\Scalar\String_('two')]);
$catch = new \PhpParser\Node\Stmt\Catch_([new \PhpParser\Node\Name\FullyQualified('CatchedType')], null, [$echo2]);
$echo3 = new \PhpParser\Node\Stmt\Echo_([new \PhpParser\Node\Scalar\String_('three')]);
$finally = new \PhpParser\Node\Stmt\Finally_([$echo3]);
return new \PhpParser\Node\Stmt\TryCatch($tryStmts, [$catch]);
