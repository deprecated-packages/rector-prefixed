<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc;

use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use PHPStan\Type\FileTypeMapper;
class PhpDocInheritanceResolver
{
    /** @var \PHPStan\Type\FileTypeMapper */
    private $fileTypeMapper;
    public function __construct(\PHPStan\Type\FileTypeMapper $fileTypeMapper)
    {
        $this->fileTypeMapper = $fileTypeMapper;
    }
    public function resolvePhpDocForProperty(?string $docComment, \RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, string $classReflectionFileName, ?string $declaringTraitName, string $propertyName) : \RectorPrefix20201227\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        $phpDocBlock = \RectorPrefix20201227\PHPStan\PhpDoc\PhpDocBlock::resolvePhpDocBlockForProperty($docComment, $classReflection, null, $propertyName, $classReflectionFileName, null, [], []);
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
    public function resolvePhpDocForMethod(?string $docComment, string $fileName, \RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection, ?string $declaringTraitName, string $methodName, array $positionalParameterNames) : \RectorPrefix20201227\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        $phpDocBlock = \RectorPrefix20201227\PHPStan\PhpDoc\PhpDocBlock::resolvePhpDocBlockForMethod($docComment, $classReflection, $declaringTraitName, $methodName, $fileName, null, $positionalParameterNames, $positionalParameterNames);
        return $this->docBlockTreeToResolvedDocBlock($phpDocBlock, $phpDocBlock->getTrait(), $methodName);
    }
    private function docBlockTreeToResolvedDocBlock(\RectorPrefix20201227\PHPStan\PhpDoc\PhpDocBlock $phpDocBlock, ?string $traitName, ?string $functionName) : \RectorPrefix20201227\PHPStan\PhpDoc\ResolvedPhpDocBlock
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
    private function docBlockToResolvedDocBlock(\RectorPrefix20201227\PHPStan\PhpDoc\PhpDocBlock $phpDocBlock, ?string $traitName, ?string $functionName) : \RectorPrefix20201227\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        $classReflection = $phpDocBlock->getClassReflection();
        return $this->fileTypeMapper->getResolvedPhpDoc($phpDocBlock->getFile(), $classReflection->getName(), $traitName, $functionName, $phpDocBlock->getDocComment());
    }
}
