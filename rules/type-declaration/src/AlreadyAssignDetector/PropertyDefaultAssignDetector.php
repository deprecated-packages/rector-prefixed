<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
final class PropertyDefaultAssignDetector
{
    public function detect(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : bool
    {
        $property = $classLike->getProperty($propertyName);
        if ($property === null) {
            return \false;
        }
        return $property->props[0]->default !== null;
    }
}
