<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
$value = new \PhpParser\Node\Expr\Variable('Tom');
$key = new \PhpParser\Node\Scalar\String_('name');
$arrayItem = new \PhpParser\Node\Expr\ArrayItem($value, $key);
return new \PhpParser\Node\Expr\Array_([$arrayItem]);
