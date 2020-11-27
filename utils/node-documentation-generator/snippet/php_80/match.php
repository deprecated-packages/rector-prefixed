<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use PhpParser\Node\Expr\Match_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\MatchArm;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
$variable = new \PhpParser\Node\Expr\Variable('variableName');
$body = new \PhpParser\Node\Scalar\String_('yes');
$cond = new \PhpParser\Node\Scalar\LNumber(1);
$matchArm = new \PhpParser\Node\MatchArm([$cond], $body);
return new \PhpParser\Node\Expr\Match_($variable, [$matchArm]);
