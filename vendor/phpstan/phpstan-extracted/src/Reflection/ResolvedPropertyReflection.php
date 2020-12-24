<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpPropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class ResolvedPropertyReflection implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
{
    /** @var PropertyReflection */
    private $reflection;
    /** @var TemplateTypeMap */
    private $templateTypeMap;
    /** @var Type|null */
    private $readableType = null;
    /** @var Type|null */
    private $writableType = null;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection $reflection, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap)
    {
        $this->reflection = $reflection;
        $this->templateTypeMap = $templateTypeMap;
    }
    public function getOriginalReflection() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
    {
        return $this->reflection;
    }
    public function getDeclaringClass() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
    {
        return $this->reflection->getDeclaringClass();
    }
    public function getDeclaringTrait() : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
    {
        if ($this->reflection instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpPropertyReflection) {
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
    public function getReadableType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $this->readableType;
        if ($type !== null) {
            return $type;
        }
        $type = \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($this->reflection->getReadableType(), $this->templateTypeMap);
        $this->readableType = $type;
        return $type;
    }
    public function getWritableType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $this->writableType;
        if ($type !== null) {
            return $type;
        }
        $type = \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($this->reflection->getWritableType(), $this->templateTypeMap);
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
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
}
