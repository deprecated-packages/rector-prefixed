<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\ValueObject;

final class AddPropertyByParent
{
    /**
     * @var string
     */
    private $parentClass;
    /**
     * @var string
     */
    private $dependencyType;
    public function __construct(string $parentClass, string $dependencyType)
    {
        $this->parentClass = $parentClass;
        $this->dependencyType = $dependencyType;
    }
    public function getParentClass() : string
    {
        return $this->parentClass;
    }
    public function getDependencyType() : string
    {
        return $this->dependencyType;
    }
}
