<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject;

use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
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
    public function __construct(string $class, string $method, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $returnType)
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
    public function getReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->returnType;
    }
}
