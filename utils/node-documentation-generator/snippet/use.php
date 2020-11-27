<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
$useUse = new \PhpParser\Node\Stmt\UseUse(new \PhpParser\Node\Name('UsedNamespace'));
return new \PhpParser\Node\Stmt\Use_([$useUse]);
