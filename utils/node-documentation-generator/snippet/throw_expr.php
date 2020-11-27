<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use PhpParser\Node\Expr\Throw_;
use PhpParser\Node\Scalar\String_;
$string = new \PhpParser\Node\Scalar\String_('some string');
return new \PhpParser\Node\Expr\Throw_($string);
