<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ClassStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IterableType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NeverType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VoidType;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\OverrideGuard\ClassMethodReturnTypeOverrideGuard;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeNormalizer;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddArrayReturnDocTypeRector\AddArrayReturnDocTypeRectorTest
 */
final class AddArrayReturnDocTypeRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeNormalizer $typeNormalizer, \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\OverrideGuard\ClassMethodReturnTypeOverrideGuard $classMethodReturnTypeOverrideGuard)
    {
        $this->returnTypeInferer = $returnTypeInferer;
        $this->typeNormalizer = $typeNormalizer;
        $this->classMethodReturnTypeOverrideGuard = $classMethodReturnTypeOverrideGuard;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds @return annotation to array parameters inferred from the rest of the code', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $inferedType = $this->returnTypeInferer->inferFunctionLikeWithExcludedInferers($node, [\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer::class]);
        $currentReturnType = $this->getNodeReturnPhpDocType($node);
        if ($currentReturnType !== null && $this->classMethodReturnTypeOverrideGuard->shouldSkipClassMethodOldTypeWithNewType($currentReturnType, $inferedType)) {
            return null;
        }
        if ($this->shouldSkipType($inferedType, $node)) {
            return null;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $phpDocInfo->changeReturnType($inferedType);
        return $node;
    }
    private function shouldSkip(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($this->shouldSkipClassMethod($classMethod)) {
            return \true;
        }
        $currentPhpDocReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if ($currentPhpDocReturnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType && $currentPhpDocReturnType->getItemType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return \true;
        }
        return $currentPhpDocReturnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IterableType;
    }
    private function getNodeReturnPhpDocType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
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
    private function shouldSkipType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $newType, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($newType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType && $this->shouldSkipArrayType($newType, $classMethod)) {
            return \true;
        }
        if ($newType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType && $this->shouldSkipUnionType($newType)) {
            return \true;
        }
        // not an array type
        if ($newType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType) {
            return \true;
        }
        if ($this->isMoreSpecificArrayTypeOverride($newType, $classMethod)) {
            return \true;
        }
        if (!$newType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType) {
            return \false;
        }
        return \count($newType->getValueTypes()) > self::MAX_NUMBER_OF_TYPES;
    }
    private function shouldSkipClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($this->classMethodReturnTypeOverrideGuard->shouldSkipClassMethod($classMethod)) {
            return \true;
        }
        if ($classMethod->returnType === null) {
            return \false;
        }
        return !$this->isNames($classMethod->returnType, ['array', 'iterable']);
    }
    private function shouldSkipArrayType(\_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType $arrayType, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($this->isNewAndCurrentTypeBothCallable($arrayType, $classMethod)) {
            return \true;
        }
        if ($this->isClassStringArrayByStringArrayOverride($arrayType, $classMethod)) {
            return \true;
        }
        return $this->isMixedOfSpecificOverride($arrayType, $classMethod);
    }
    private function shouldSkipUnionType(\_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType $unionType) : bool
    {
        return \count($unionType->getTypes()) > self::MAX_NUMBER_OF_TYPES;
    }
    private function isMoreSpecificArrayTypeOverride(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $newType, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$newType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType) {
            return \false;
        }
        if (!$newType->getItemType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType) {
            return \false;
        }
        $phpDocReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if (!$phpDocReturnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
            return \false;
        }
        return !$phpDocReturnType->getItemType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType;
    }
    private function isNewAndCurrentTypeBothCallable(\_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType $newArrayType, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $currentReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if (!$currentReturnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$newArrayType->getItemType()->isCallable()->yes()) {
            return \false;
        }
        return $currentReturnType->getItemType()->isCallable()->yes();
    }
    private function isClassStringArrayByStringArrayOverride(\_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType $arrayType, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$arrayType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType) {
            return \false;
        }
        $arrayType = $this->typeNormalizer->convertConstantArrayTypeToArrayType($arrayType);
        if ($arrayType === null) {
            return \false;
        }
        $currentReturnType = $this->getNodeReturnPhpDocType($classMethod);
        if (!$currentReturnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$currentReturnType->getItemType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ClassStringType) {
            return \false;
        }
        return $arrayType->getItemType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
    }
    private function isMixedOfSpecificOverride(\_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType $arrayType, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$arrayType->getItemType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return \false;
        }
        $currentReturnType = $this->getNodeReturnPhpDocType($classMethod);
        return $currentReturnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
    }
}
