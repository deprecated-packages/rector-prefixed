<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
$class = new \PhpParser\Node\Name('SomeClass');
return new \PhpParser\Node\Expr\New_($class);
