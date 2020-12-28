<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\ArrayType;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VoidType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\TypeDeclaration\OverrideGuard\ClassMethodReturnTypeOverrideGuard;
use Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
use Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer;
use Rector\TypeDeclaration\TypeNormalizer;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\AddArrayReturnDocTypeRectorTest
 */
final class AddArrayReturnDocTypeRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var int
     */
    private const MAX_NUMBER_OF_TYPES = 3;
    /**
     * @var ReturnTypeInferer
     */
    private $returnTypeInferer;
    /**
     * @var TypeNormalizer
     */
    private $typeNormalizer;
    /**
     * @var ClassMethodReturnTypeOverrideGuard
     */
    private $classMethodReturnTypeOverrideGuard;
    public function __construct(\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \Rector\TypeDeclaration\TypeNormalizer $typeNormalizer, \Rector\TypeDeclaration\OverrideGuard\ClassMethodReturnTypeOverrideGuard $classMethodReturnTypeOverrideGuard)
    {
        $this->returnTypeInferer = $returnTypeInferer;
        $this->typeNormalizer = $typeNormalizer;
        $this->classMethodReturnTypeOverrideGuard = $classMethodReturnTypeOverrideGuard;
    }
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds @return annotation to array parameters inferred from the rest of the code', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var int[]
     */
    private $values;

    public function getValues(): array
    {
        return $this->values;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var int[]
     */
    private $values;

    /**
     * @return int[]
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $inferedType = $this->returnTypeInferer->inferFunctionLikeWithExcludedInferers($node, [\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer::class]);
        $currentReturnType = $this->getNodeReturnPhpDocType($node);
        if ($currentReturnType !== null && $this->classMethodReturnTypeOverrideGuard->shouldSkipClassMethodOldTypeWithNewType($currentReturnType, $inferedType)) {
            return null;
        }
        if ($this->shouldSkipType($inferedType, $node)) {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $phpDocInfo->changeReturnType($inferedType);
        return $node;
    }
    private function shouldSkip(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($this->shouldSkipClassMethod($classMethod)) {
            return \true;
        }
        $currentPhpDocReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if ($currentPhpDocReturnType instanceof \PHPStan\Type\ArrayType && $currentPhpDocReturnType->getItemType() instanceof \PHPStan\Type\MixedType) {
            return \true;
        }
        return $currentPhpDocReturnType instanceof \PHPStan\Type\IterableType;
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
    /**
     * @deprecated
     * @todo merge to
     * @see \Rector\TypeDeclaration\TypeAlreadyAddedChecker\ReturnTypeAlreadyAddedChecker
     */
    private function shouldSkipType(\PHPStan\Type\Type $newType, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($newType instanceof \PHPStan\Type\ArrayType && $this->shouldSkipArrayType($newType, $classMethod)) {
            return \true;
        }
        if ($newType instanceof \PHPStan\Type\UnionType && $this->shouldSkipUnionType($newType)) {
            return \true;
        }
        // not an array type
        if ($newType instanceof \PHPStan\Type\VoidType) {
            return \true;
        }
        if ($this->isMoreSpecificArrayTypeOverride($newType, $classMethod)) {
            return \true;
        }
        if (!$newType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return \false;
        }
        return \count($newType->getValueTypes()) > self::MAX_NUMBER_OF_TYPES;
    }
    private function shouldSkipClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($this->classMethodReturnTypeOverrideGuard->shouldSkipClassMethod($classMethod)) {
            return \true;
        }
        if ($classMethod->returnType === null) {
            return \false;
        }
        return !$this->isNames($classMethod->returnType, ['array', 'iterable']);
    }
    private function shouldSkipArrayType(\PHPStan\Type\ArrayType $arrayType, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($this->isNewAndCurrentTypeBothCallable($arrayType, $classMethod)) {
            return \true;
        }
        if ($this->isClassStringArrayByStringArrayOverride($arrayType, $classMethod)) {
            return \true;
        }
        return $this->isMixedOfSpecificOverride($arrayType, $classMethod);
    }
    private function shouldSkipUnionType(\PHPStan\Type\UnionType $unionType) : bool
    {
        return \count($unionType->getTypes()) > self::MAX_NUMBER_OF_TYPES;
    }
    private function isMoreSpecificArrayTypeOverride(\PHPStan\Type\Type $newType, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
    private function isNewAndCurrentTypeBothCallable(\PHPStan\Type\ArrayType $newArrayType, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
    private function isClassStringArrayByStringArrayOverride(\PHPStan\Type\ArrayType $arrayType, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
    private function isMixedOfSpecificOverride(\PHPStan\Type\ArrayType $arrayType, \PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$arrayType->getItemType() instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        $currentReturnType = $this->getNodeReturnPhpDocType($classMethod);
        return $currentReturnType instanceof \PHPStan\Type\ArrayType;
    }
}
