<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name\FullyQualified;
$fullyQualified = new \PhpParser\Node\Name\FullyQualified('ClassName');
return new \PhpParser\Node\Expr\StaticCall($fullyQualified, 'methodName');
