<?php

declare (strict_types=1);
namespace Rector\CakePHP\ValueObject;

use PHPStan\Type\ObjectType;
final class ModalToGetSet
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $unprefixedMethod;
    /**
     * @var string
     */
    private $getMethod;
    /**
     * @var string
     */
    private $setMethod;
    /**
     * @var int
     */
    private $minimalSetterArgumentCount;
    /**
     * @var string|null
     */
    private $firstArgumentType;
    public function __construct(string $type, string $unprefixedMethod, ?string $getMethod = null, ?string $setMethod = null, int $minimalSetterArgumentCount = 1, ?string $firstArgumentType = null)
    {
        $this->type = $type;
        $this->unprefixedMethod = $unprefixedMethod;
        $this->getMethod = $getMethod ?? 'get' . \ucfirst($unprefixedMethod);
        $this->setMethod = $setMethod ?? 'set' . \ucfirst($unprefixedMethod);
        $this->minimalSetterArgumentCount = $minimalSetterArgumentCount;
        $this->firstArgumentType = $firstArgumentType;
    }
    public function getObjectType() : \PHPStan\Type\ObjectType
    {
        return new \PHPStan\Type\ObjectType($this->type);
    }
    public function getUnprefixedMethod() : string
    {
        return $this->unprefixedMethod;
    }
    public function getGetMethod() : string
    {
        return $this->getMethod;
    }
    public function getSetMethod() : string
    {
        return $this->setMethod;
    }
    public function getMinimalSetterArgumentCount() : int
    {
        return $this->minimalSetterArgumentCount;
    }
    public function getFirstArgumentType() : ?string
    {
        return $this->firstArgumentType;
    }
}
