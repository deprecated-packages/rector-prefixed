<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
final class AddReturnTypeDeclaration
{
    /**
     * @var string
     */
    private $class;
    /**
     * @var string
     */
    private $method;
    /**
     * @var Type
     */
    private $returnType;
    public function __construct(string $class, string $method, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $returnType)
    {
        $this->class = $class;
        $this->method = $method;
        $this->returnType = $returnType;
    }
    public function getClass() : string
    {
        return $this->class;
    }
    public function getMethod() : string
    {
        return $this->method;
    }
    public function getReturnType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->returnType;
    }
}
