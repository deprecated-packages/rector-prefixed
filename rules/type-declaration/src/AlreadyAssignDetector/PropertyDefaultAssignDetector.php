<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
final class PropertyDefaultAssignDetector
{
    public function detect(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : bool
    {
        $property = $classLike->getProperty($propertyName);
        if ($property === null) {
            return \false;
        }
        return $property->props[0]->default !== null;
    }
}
