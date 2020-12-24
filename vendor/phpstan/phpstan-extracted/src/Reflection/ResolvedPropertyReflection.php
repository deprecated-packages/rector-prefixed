<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpPropertyReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class ResolvedPropertyReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
{
    /** @var PropertyReflection */
    private $reflection;
    /** @var TemplateTypeMap */
    private $templateTypeMap;
    /** @var Type|null */
    private $readableType = null;
    /** @var Type|null */
    private $writableType = null;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection $reflection, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap)
    {
        $this->reflection = $reflection;
        $this->templateTypeMap = $templateTypeMap;
    }
    public function getOriginalReflection() : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
    {
        return $this->reflection;
    }
    public function getDeclaringClass() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return $this->reflection->getDeclaringClass();
    }
    public function getDeclaringTrait() : ?\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        if ($this->reflection instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpPropertyReflection) {
            return $this->reflection->getDeclaringTrait();
        }
        return null;
    }
    public function isStatic() : bool
    {
        return $this->reflection->isStatic();
    }
    public function isPrivate() : bool
    {
        return $this->reflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->reflection->isPublic();
    }
    public function getReadableType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->readableType;
        if ($type !== null) {
            return $type;
        }
        $type = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($this->reflection->getReadableType(), $this->templateTypeMap);
        $this->readableType = $type;
        return $type;
    }
    public function getWritableType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->writableType;
        if ($type !== null) {
            return $type;
        }
        $type = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($this->reflection->getWritableType(), $this->templateTypeMap);
        $this->writableType = $type;
        return $type;
    }
    public function canChangeTypeAfterAssignment() : bool
    {
        return $this->reflection->canChangeTypeAfterAssignment();
    }
    public function isReadable() : bool
    {
        return $this->reflection->isReadable();
    }
    public function isWritable() : bool
    {
        return $this->reflection->isWritable();
    }
    public function getDocComment() : ?string
    {
        return $this->reflection->getDocComment();
    }
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
}
