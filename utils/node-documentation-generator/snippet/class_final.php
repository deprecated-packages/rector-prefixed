<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use PhpParser\Node\Stmt\Class_;
$class = new \PhpParser\Node\Stmt\Class_('ClassName');
$class->flags |= \PhpParser\Node\Stmt\Class_::MODIFIER_FINAL;
return $class;
