<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use PhpParser\Node\Const_;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
$defaultValue = new \PhpParser\Node\Scalar\String_('default value');
$const = new \PhpParser\Node\Const_('SOME_CLASS_CONSTANT', $defaultValue);
return new \PhpParser\Node\Stmt\ClassConst([$const], \PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC);
