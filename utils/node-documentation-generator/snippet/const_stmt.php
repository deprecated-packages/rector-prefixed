<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use PhpParser\Node\Const_;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Const_ as ConstStmt;
$consts = [new \PhpParser\Node\Const_('CONSTANT_IN_CLASS', new \PhpParser\Node\Scalar\String_('default value'))];
return new \PhpParser\Node\Stmt\Const_($consts);
