<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
$variable = new \PhpParser\Node\Expr\Variable('variableName');
$value = new \PhpParser\Node\Scalar\String_('some value');
return new \PhpParser\Node\Expr\Assign($variable, $value);
