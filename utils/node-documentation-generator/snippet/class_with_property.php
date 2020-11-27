<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
$class = new \PhpParser\Node\Stmt\Class_('ClassName');
$propertyProperty = new \PhpParser\Node\Stmt\PropertyProperty('someProperty');
$property = new \PhpParser\Node\Stmt\Property(\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE, [$propertyProperty]);
$class->stmts[] = $property;
return $propertyProperty;
