<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper;
class PhpDocInheritanceResolver
{
    /** @var \PHPStan\Type\FileTypeMapper */
    private $fileTypeMapper;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper $fileTypeMapper)
    {
        $this->fileTypeMapper = $fileTypeMapper;
    }
    public function resolvePhpDocForProperty(?string $docComment, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, string $classReflectionFileName, ?string $declaringTraitName, string $propertyName) : \_PhpScopere8e811afab72\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        $phpDocBlock = \_PhpScopere8e811afab72\PHPStan\PhpDoc\PhpDocBlock::resolvePhpDocBlockForProperty($docComment, $classReflection, null, $propertyName, $classReflectionFileName, null, [], []);
        return $this->docBlockTreeToResolvedDocBlock($phpDocBlock, $declaringTraitName, null);
    }
    /**
     * @param string|null $docComment
     * @param string $fileName
     * @param ClassReflection $classReflection
     * @param string|null $declaringTraitName
     * @param string $methodName
     * @param array<int, string> $positionalParameterNames
     * @return ResolvedPhpDocBlock
     */
    public function resolvePhpDocForMethod(?string $docComment, string $fileName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection, ?string $declaringTraitName, string $methodName, array $positionalParameterNames) : \_PhpScopere8e811afab72\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        $phpDocBlock = \_PhpScopere8e811afab72\PHPStan\PhpDoc\PhpDocBlock::resolvePhpDocBlockForMethod($docComment, $classReflection, $declaringTraitName, $methodName, $fileName, null, $positionalParameterNames, $positionalParameterNames);
        return $this->docBlockTreeToResolvedDocBlock($phpDocBlock, $phpDocBlock->getTrait(), $methodName);
    }
    private function docBlockTreeToResolvedDocBlock(\_PhpScopere8e811afab72\PHPStan\PhpDoc\PhpDocBlock $phpDocBlock, ?string $traitName, ?string $functionName) : \_PhpScopere8e811afab72\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        $parents = [];
        $parentPhpDocBlocks = [];
        foreach ($phpDocBlock->getParents() as $parentPhpDocBlock) {
            if ($parentPhpDocBlock->getClassReflection()->isBuiltin() && $functionName !== null && \strtolower($functionName) === '__construct') {
                continue;
            }
            $parents[] = $this->docBlockTreeToResolvedDocBlock($parentPhpDocBlock, $parentPhpDocBlock->getTrait(), $functionName);
            $parentPhpDocBlocks[] = $parentPhpDocBlock;
        }
        $oneResolvedDockBlock = $this->docBlockToResolvedDocBlock($phpDocBlock, $traitName, $functionName);
        return $oneResolvedDockBlock->merge($parents, $parentPhpDocBlocks);
    }
    private function docBlockToResolvedDocBlock(\_PhpScopere8e811afab72\PHPStan\PhpDoc\PhpDocBlock $phpDocBlock, ?string $traitName, ?string $functionName) : \_PhpScopere8e811afab72\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        $classReflection = $phpDocBlock->getClassReflection();
        return $this->fileTypeMapper->getResolvedPhpDoc($phpDocBlock->getFile(), $classReflection->getName(), $traitName, $functionName, $phpDocBlock->getDocComment());
    }
}
