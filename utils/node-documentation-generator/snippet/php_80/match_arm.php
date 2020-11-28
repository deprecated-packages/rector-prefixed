<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use PhpParser\Node\MatchArm;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
$conds = [new \PhpParser\Node\Scalar\LNumber(1)];
$body = new \PhpParser\Node\Scalar\String_('yes');
return new \PhpParser\Node\MatchArm($conds, $body);
