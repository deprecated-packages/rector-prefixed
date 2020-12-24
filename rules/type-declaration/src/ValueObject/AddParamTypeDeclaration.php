<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
final class AddParamTypeDeclaration
{
    /**
     * @var string
     */
    private $className;
    /**
     * @var string
     */
    private $methodName;
    /**
     * @var int
     */
    private $position;
    /**
     * @var Type
     */
    private $paramType;
    public function __construct(string $className, string $methodName, int $position, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $paramType)
    {
        $this->className = $className;
        $this->methodName = $methodName;
        $this->position = $position;
        $this->paramType = $paramType;
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function getMethodName() : string
    {
        return $this->methodName;
    }
    public function getPosition() : int
    {
        return $this->position;
    }
    public function getParamType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->paramType;
    }
}
