<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
final class PropertyDefaultAssignDetector
{
    public function detect(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : bool
    {
        $property = $classLike->getProperty($propertyName);
        if ($property === null) {
            return \false;
        }
        return $property->props[0]->default !== null;
    }
}
