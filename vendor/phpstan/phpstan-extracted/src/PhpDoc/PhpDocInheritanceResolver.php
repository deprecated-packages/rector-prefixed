<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper;
class PhpDocInheritanceResolver
{
    /** @var \PHPStan\Type\FileTypeMapper */
    private $fileTypeMapper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\FileTypeMapper $fileTypeMapper)
    {
        $this->fileTypeMapper = $fileTypeMapper;
    }
    public function resolvePhpDocForProperty(?string $docComment, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, string $classReflectionFileName, ?string $declaringTraitName, string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        $phpDocBlock = \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocBlock::resolvePhpDocBlockForProperty($docComment, $classReflection, null, $propertyName, $classReflectionFileName, null, [], []);
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
    public function resolvePhpDocForMethod(?string $docComment, string $fileName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection, ?string $declaringTraitName, string $methodName, array $positionalParameterNames) : \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        $phpDocBlock = \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocBlock::resolvePhpDocBlockForMethod($docComment, $classReflection, $declaringTraitName, $methodName, $fileName, null, $positionalParameterNames, $positionalParameterNames);
        return $this->docBlockTreeToResolvedDocBlock($phpDocBlock, $phpDocBlock->getTrait(), $methodName);
    }
    private function docBlockTreeToResolvedDocBlock(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocBlock $phpDocBlock, ?string $traitName, ?string $functionName) : \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\ResolvedPhpDocBlock
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
    private function docBlockToResolvedDocBlock(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\PhpDocBlock $phpDocBlock, ?string $traitName, ?string $functionName) : \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        $classReflection = $phpDocBlock->getClassReflection();
        return $this->fileTypeMapper->getResolvedPhpDoc($phpDocBlock->getFile(), $classReflection->getName(), $traitName, $functionName, $phpDocBlock->getDocComment());
    }
}
