<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
$args = [new \PhpParser\Node\Arg(new \PhpParser\Node\Expr\Variable('someVariable'))];
return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name('func_call'), $args);
