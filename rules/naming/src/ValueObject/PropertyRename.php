<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScopere8e811afab72\Rector\Naming\Contract\RenamePropertyValueObjectInterface;
final class PropertyRename implements \_PhpScopere8e811afab72\Rector\Naming\Contract\RenamePropertyValueObjectInterface
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
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property, string $expectedName, string $currentName, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike, string $classLikeName, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\PropertyProperty $propertyProperty)
    {
        $this->property = $property;
        $this->expectedName = $expectedName;
        $this->currentName = $currentName;
        $this->classLike = $classLike;
        $this->classLikeName = $classLikeName;
        $this->propertyProperty = $propertyProperty;
    }
    public function getProperty() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property
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
    public function getClassLike() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike
    {
        return $this->classLike;
    }
    public function getClassLikeName() : string
    {
        return $this->classLikeName;
    }
    public function getPropertyProperty() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\PropertyProperty
    {
        return $this->propertyProperty;
    }
}
