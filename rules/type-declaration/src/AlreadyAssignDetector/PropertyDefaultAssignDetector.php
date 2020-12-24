<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
final class PropertyDefaultAssignDetector
{
    public function detect(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : bool
    {
        $property = $classLike->getProperty($propertyName);
        if ($property === null) {
            return \false;
        }
        return $property->props[0]->default !== null;
    }
}
