<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Name\FullyQualified;
$class = new \PhpParser\Node\Name\FullyQualified('StaticClassName');
return new \PhpParser\Node\Expr\StaticPropertyFetch($class, 'someProperty');
