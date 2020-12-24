<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\OverrideGuard\ClassMethodReturnTypeOverrideGuard;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeNormalizer;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\AddArrayReturnDocTypeRectorTest
 */
final class AddArrayReturnDocTypeRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeNormalizer $typeNormalizer, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\OverrideGuard\ClassMethodReturnTypeOverrideGuard $classMethodReturnTypeOverrideGuard)
    {
        $this->returnTypeInferer = $returnTypeInferer;
        $this->typeNormalizer = $typeNormalizer;
        $this->classMethodReturnTypeOverrideGuard = $classMethodReturnTypeOverrideGuard;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds @return annotation to array parameters inferred from the rest of the code', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $inferedType = $this->returnTypeInferer->inferFunctionLikeWithExcludedInferers($node, [\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer::class]);
        $currentReturnType = $this->getNodeReturnPhpDocType($node);
        if ($currentReturnType !== null && $this->classMethodReturnTypeOverrideGuard->shouldSkipClassMethodOldTypeWithNewType($currentReturnType, $inferedType)) {
            return null;
        }
        if ($this->shouldSkipType($inferedType, $node)) {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $phpDocInfo->changeReturnType($inferedType);
        return $node;
    }
    private function shouldSkip(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($this->shouldSkipClassMethod($classMethod)) {
            return \true;
        }
        $currentPhpDocReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if ($currentPhpDocReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType && $currentPhpDocReturnType->getItemType() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return \true;
        }
        return $currentPhpDocReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
    }
    private function getNodeReturnPhpDocType(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
    private function shouldSkipType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $newType, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($newType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType && $this->shouldSkipArrayType($newType, $classMethod)) {
            return \true;
        }
        if ($newType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType && $this->shouldSkipUnionType($newType)) {
            return \true;
        }
        // not an array type
        if ($newType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType) {
            return \true;
        }
        if ($this->isMoreSpecificArrayTypeOverride($newType, $classMethod)) {
            return \true;
        }
        if (!$newType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType) {
            return \false;
        }
        return \count($newType->getValueTypes()) > self::MAX_NUMBER_OF_TYPES;
    }
    private function shouldSkipClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($this->classMethodReturnTypeOverrideGuard->shouldSkipClassMethod($classMethod)) {
            return \true;
        }
        if ($classMethod->returnType === null) {
            return \false;
        }
        return !$this->isNames($classMethod->returnType, ['array', 'iterable']);
    }
    private function shouldSkipArrayType(\_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType $arrayType, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($this->isNewAndCurrentTypeBothCallable($arrayType, $classMethod)) {
            return \true;
        }
        if ($this->isClassStringArrayByStringArrayOverride($arrayType, $classMethod)) {
            return \true;
        }
        return $this->isMixedOfSpecificOverride($arrayType, $classMethod);
    }
    private function shouldSkipUnionType(\_PhpScoperb75b35f52b74\PHPStan\Type\UnionType $unionType) : bool
    {
        return \count($unionType->getTypes()) > self::MAX_NUMBER_OF_TYPES;
    }
    private function isMoreSpecificArrayTypeOverride(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $newType, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$newType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType) {
            return \false;
        }
        if (!$newType->getItemType() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType) {
            return \false;
        }
        $phpDocReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if (!$phpDocReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return \false;
        }
        return !$phpDocReturnType->getItemType() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
    }
    private function isNewAndCurrentTypeBothCallable(\_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType $newArrayType, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $currentReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if (!$currentReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$newArrayType->getItemType()->isCallable()->yes()) {
            return \false;
        }
        return $currentReturnType->getItemType()->isCallable()->yes();
    }
    private function isClassStringArrayByStringArrayOverride(\_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType $arrayType, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$arrayType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType) {
            return \false;
        }
        $arrayType = $this->typeNormalizer->convertConstantArrayTypeToArrayType($arrayType);
        if ($arrayType === null) {
            return \false;
        }
        $currentReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if (!$currentReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$currentReturnType->getItemType() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType) {
            return \false;
        }
        return $arrayType->getItemType() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StringType;
    }
    private function isMixedOfSpecificOverride(\_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType $arrayType, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$arrayType->getItemType() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return \false;
        }
        $currentReturnType = $this->getNodeReturnPhpDocType($classMethod);
        return $currentReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
    }
}
