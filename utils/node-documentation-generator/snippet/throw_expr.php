<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use PhpParser\Node\Expr\Throw_;
use PhpParser\Node\Scalar\String_;
$string = new \PhpParser\Node\Scalar\String_('some string');
return new \PhpParser\Node\Expr\Throw_($string);