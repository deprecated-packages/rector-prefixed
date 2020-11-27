<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use PhpParser\Node\Stmt\Class_;
$class = new \PhpParser\Node\Stmt\Class_('ClassName');
$class->flags |= \PhpParser\Node\Stmt\Class_::MODIFIER_FINAL;
return $class;
