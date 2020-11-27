<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
$class = new \PhpParser\Node\Stmt\Class_('ClassName');
$class->flags = \PhpParser\Node\Stmt\Class_::MODIFIER_FINAL;
$class->extends = new \PhpParser\Node\Name\FullyQualified('ParentClass');
return $class;
