<?php

declare (strict_types=1);
namespace Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source;

final class ServiceWithValueObject
{
    /**
     * @var WithType
     */
    private $withType;
    /**
     * @var WithType[]
     */
    private $withTypes = [];
    public function setWithType(\Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\WithType $withType) : void
    {
        $this->withType = $withType;
    }
    public function getWithType() : \Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\WithType
    {
        return $this->withType;
    }
    /**
     * @param WithType[] $withTypes
     */
    public function setWithTypes(array $withTypes) : void
    {
        $this->withTypes = $withTypes;
    }
    /**
     * @return WithType[]
     */
    public function getWithTypes() : array
    {
        return $this->withTypes;
    }
}
