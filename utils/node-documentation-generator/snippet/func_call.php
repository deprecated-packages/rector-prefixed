<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
$args = [new \PhpParser\Node\Arg(new \PhpParser\Node\Expr\Variable('someVariable'))];
return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name('func_call'), $args);
