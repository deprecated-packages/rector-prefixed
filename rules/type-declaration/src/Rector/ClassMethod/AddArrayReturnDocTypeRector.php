<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VoidType;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayShapeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Rector\AbstractRector;
use Rector\Privatization\TypeManipulator\NormalizeTypeToRespectArrayScalarType;
use Rector\TypeDeclaration\TypeAnalyzer\AdvancedArrayAnalyzer;
use Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
use Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer;
use Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnTypeOverrideGuard;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
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
     * @var ClassMethodReturnTypeOverrideGuard
     */
    private $classMethodReturnTypeOverrideGuard;
    /**
     * @var AdvancedArrayAnalyzer
     */
    private $advancedArrayAnalyzer;
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    /**
     * @var NormalizeTypeToRespectArrayScalarType
     */
    private $normalizeTypeToRespectArrayScalarType;
    public function __construct(\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnTypeOverrideGuard $classMethodReturnTypeOverrideGuard, \Rector\TypeDeclaration\TypeAnalyzer\AdvancedArrayAnalyzer $advancedArrayAnalyzer, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger, \Rector\Privatization\TypeManipulator\NormalizeTypeToRespectArrayScalarType $normalizeTypeToRespectArrayScalarType)
    {
        $this->returnTypeInferer = $returnTypeInferer;
        $this->classMethodReturnTypeOverrideGuard = $classMethodReturnTypeOverrideGuard;
        $this->advancedArrayAnalyzer = $advancedArrayAnalyzer;
        $this->phpDocTypeChanger = $phpDocTypeChanger;
        $this->normalizeTypeToRespectArrayScalarType = $normalizeTypeToRespectArrayScalarType;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds @return annotation to array parameters inferred from the rest of the code', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        if ($this->shouldSkip($node, $phpDocInfo)) {
            return null;
        }
        $inferredReturnType = $this->returnTypeInferer->inferFunctionLikeWithExcludedInferers($node, [\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer::class]);
        $inferredReturnType = $this->normalizeTypeToRespectArrayScalarType->normalizeToArray($inferredReturnType, $node->returnType);
        $currentReturnType = $phpDocInfo->getReturnType();
        if ($this->classMethodReturnTypeOverrideGuard->shouldSkipClassMethodOldTypeWithNewType($currentReturnType, $inferredReturnType)) {
            return null;
        }
        if ($this->shouldSkipType($inferredReturnType, $node, $phpDocInfo)) {
            return null;
        }
        $this->phpDocTypeChanger->changeReturnType($phpDocInfo, $inferredReturnType);
        return $node;
    }
    private function shouldSkip(\PhpParser\Node\Stmt\ClassMethod $classMethod, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : bool
    {
        if ($this->shouldSkipClassMethod($classMethod)) {
            return \true;
        }
        if ($this->hasArrayShapeNode($classMethod)) {
            return \true;
        }
        $currentPhpDocReturnType = $phpDocInfo->getReturnType();
        if ($currentPhpDocReturnType instanceof \PHPStan\Type\ArrayType && $currentPhpDocReturnType->getItemType() instanceof \PHPStan\Type\MixedType) {
            return \true;
        }
        if ($this->hasInheritDoc($classMethod)) {
            return \true;
        }
        return $currentPhpDocReturnType instanceof \PHPStan\Type\IterableType;
    }
    /**
     * @deprecated
     * @todo merge to
     * @see \Rector\TypeDeclaration\TypeAlreadyAddedChecker\ReturnTypeAlreadyAddedChecker
     */
    private function shouldSkipType(\PHPStan\Type\Type $newType, \PhpParser\Node\Stmt\ClassMethod $classMethod, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : bool
    {
        if ($newType instanceof \PHPStan\Type\ArrayType && $this->shouldSkipArrayType($newType, $classMethod, $phpDocInfo)) {
            return \true;
        }
        if ($newType instanceof \PHPStan\Type\UnionType && $this->shouldSkipUnionType($newType)) {
            return \true;
        }
        // not an array type
        if ($newType instanceof \PHPStan\Type\VoidType) {
            return \true;
        }
        if ($this->advancedArrayAnalyzer->isMoreSpecificArrayTypeOverride($newType, $classMethod, $phpDocInfo)) {
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
    private function hasArrayShapeNode(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $attributeAwareReturnTagValueNode = $phpDocInfo->getReturnTagValue();
        if (!$attributeAwareReturnTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode) {
            return \false;
        }
        if ($attributeAwareReturnTagValueNode->type instanceof \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode) {
            return \true;
        }
        if ($attributeAwareReturnTagValueNode->type instanceof \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayShapeNode) {
            return \true;
        }
        if (!$attributeAwareReturnTagValueNode->type instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode) {
            return \false;
        }
        return $attributeAwareReturnTagValueNode->type->type instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode;
    }
    private function hasInheritDoc(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        return $phpDocInfo->hasInheritDoc();
    }
    private function shouldSkipArrayType(\PHPStan\Type\ArrayType $arrayType, \PhpParser\Node\Stmt\ClassMethod $classMethod, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : bool
    {
        if ($this->advancedArrayAnalyzer->isNewAndCurrentTypeBothCallable($arrayType, $phpDocInfo)) {
            return \true;
        }
        if ($this->advancedArrayAnalyzer->isClassStringArrayByStringArrayOverride($arrayType, $classMethod)) {
            return \true;
        }
        return $this->advancedArrayAnalyzer->isMixedOfSpecificOverride($arrayType, $phpDocInfo);
    }
    private function shouldSkipUnionType(\PHPStan\Type\UnionType $unionType) : bool
    {
        return \count($unionType->getTypes()) > self::MAX_NUMBER_OF_TYPES;
    }
}
