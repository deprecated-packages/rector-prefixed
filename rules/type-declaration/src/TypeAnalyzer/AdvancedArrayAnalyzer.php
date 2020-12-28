<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeAnalyzer;

use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ArrayType;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\VoidType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\TypeDeclaration\TypeNormalizer;
final class AdvancedArrayAnalyzer
{
    /**
     * @var TypeNormalizer
     */
    private $typeNormalizer;
    public function __construct(\Rector\TypeDeclaration\TypeNormalizer $typeNormalizer)
    {
        $this->typeNormalizer = $typeNormalizer;
    }
    public function isClassStringArrayByStringArrayOverride(\PHPStan\Type\ArrayType $arrayType, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$arrayType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return \false;
        }
        $arrayType = $this->typeNormalizer->convertConstantArrayTypeToArrayType($arrayType);
        if ($arrayType === null) {
            return \false;
        }
        $currentReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if (!$currentReturnType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$currentReturnType->getItemType() instanceof \PHPStan\Type\ClassStringType) {
            return \false;
        }
        return $arrayType->getItemType() instanceof \PHPStan\Type\StringType;
    }
    public function isMixedOfSpecificOverride(\PHPStan\Type\ArrayType $arrayType, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$arrayType->getItemType() instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        $currentReturnType = $this->getNodeReturnPhpDocType($classMethod);
        return $currentReturnType instanceof \PHPStan\Type\ArrayType;
    }
    public function isMoreSpecificArrayTypeOverride(\PHPStan\Type\Type $newType, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$newType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return \false;
        }
        if (!$newType->getItemType() instanceof \PHPStan\Type\NeverType) {
            return \false;
        }
        $phpDocReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if (!$phpDocReturnType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        return !$phpDocReturnType->getItemType() instanceof \PHPStan\Type\VoidType;
    }
    public function isNewAndCurrentTypeBothCallable(\PHPStan\Type\ArrayType $newArrayType, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $currentReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if (!$currentReturnType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$newArrayType->getItemType()->isCallable()->yes()) {
            return \false;
        }
        return $currentReturnType->getItemType()->isCallable()->yes();
    }
    private function getNodeReturnPhpDocType(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        return $phpDocInfo->getReturnType();
    }
}
