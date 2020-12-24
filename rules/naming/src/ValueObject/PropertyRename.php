<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenamePropertyValueObjectInterface;
final class PropertyRename implements \_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenamePropertyValueObjectInterface
{
    /**
     * @var string
     */
    private $expectedName;
    /**
     * @var string
     */
    private $currentName;
    /**
     * @var string
     */
    private $classLikeName;
    /**
     * @var Property
     */
    private $property;
    /**
     * @var ClassLike
     */
    private $classLike;
    /**
     * @var PropertyProperty
     */
    private $propertyProperty;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, string $expectedName, string $currentName, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, string $classLikeName, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty $propertyProperty)
    {
        $this->property = $property;
        $this->expectedName = $expectedName;
        $this->currentName = $currentName;
        $this->classLike = $classLike;
        $this->classLikeName = $classLikeName;
        $this->propertyProperty = $propertyProperty;
    }
    public function getProperty() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property
    {
        return $this->property;
    }
    public function isPrivateProperty() : bool
    {
        return $this->property->isPrivate();
    }
    public function getExpectedName() : string
    {
        return $this->expectedName;
    }
    public function getCurrentName() : string
    {
        return $this->currentName;
    }
    public function getClassLike() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike
    {
        return $this->classLike;
    }
    public function getClassLikeName() : string
    {
        return $this->classLikeName;
    }
    public function getPropertyProperty() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty
    {
        return $this->propertyProperty;
    }
}
