<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantTypeHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
class ClassConstantReflection implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\ConstantReflection
{
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var \ReflectionClassConstant */
    private $reflection;
    /** @var string|null */
    private $deprecatedDescription;
    /** @var bool */
    private $isDeprecated;
    /** @var bool */
    private $isInternal;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $declaringClass, \ReflectionClassConstant $reflection, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal)
    {
        $this->declaringClass = $declaringClass;
        $this->reflection = $reflection;
        $this->deprecatedDescription = $deprecatedDescription;
        $this->isDeprecated = $isDeprecated;
        $this->isInternal = $isInternal;
    }
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    public function getFileName() : ?string
    {
        $fileName = $this->declaringClass->getFileName();
        if ($fileName === \false) {
            return null;
        }
        return $fileName;
    }
    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->reflection->getValue();
    }
    public function getValueType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($this->getValue());
    }
    public function getDeclaringClass() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function isStatic() : bool
    {
        return \true;
    }
    public function isPrivate() : bool
    {
        return $this->reflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->reflection->isPublic();
    }
    public function isDeprecated() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean($this->isDeprecated);
    }
    public function getDeprecatedDescription() : ?string
    {
        if ($this->isDeprecated) {
            return $this->deprecatedDescription;
        }
        return null;
    }
    public function isInternal() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean($this->isInternal);
    }
    public function getDocComment() : ?string
    {
        $docComment = $this->reflection->getDocComment();
        if ($docComment === \false) {
            return null;
        }
        return $docComment;
    }
}
