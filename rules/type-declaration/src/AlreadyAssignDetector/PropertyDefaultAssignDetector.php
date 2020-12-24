<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
final class PropertyDefaultAssignDetector
{
    public function detect(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : bool
    {
        $property = $classLike->getProperty($propertyName);
        if ($property === null) {
            return \false;
        }
        return $property->props[0]->default !== null;
    }
}
