<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\VoidType;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayShapeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadDocBlock\TagRemover\ReturnTagRemover;
use Rector\Privatization\TypeManipulator\NormalizeTypeToRespectArrayScalarType;
use Rector\TypeDeclaration\NodeTypeAnalyzer\DetailedTypeAnalyzer;
use Rector\TypeDeclaration\TypeAnalyzer\AdvancedArrayAnalyzer;
use Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
use Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer;
use Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnTypeOverrideGuard;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector\AddArrayReturnDocTypeRectorTest
 */
final class AddArrayReturnDocTypeRector extends \Rector\Core\Rector\AbstractRector
{
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
    /**
     * @var ReturnTagRemover
     */
    private $returnTagRemover;
    /**
     * @var DetailedTypeAnalyzer
     */
    private $detailedTypeAnalyzer;
    public function __construct(\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnTypeOverrideGuard $classMethodReturnTypeOverrideGuard, \Rector\TypeDeclaration\TypeAnalyzer\AdvancedArrayAnalyzer $advancedArrayAnalyzer, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger, \Rector\Privatization\TypeManipulator\NormalizeTypeToRespectArrayScalarType $normalizeTypeToRespectArrayScalarType, \Rector\DeadDocBlock\TagRemover\ReturnTagRemover $returnTagRemover, \Rector\TypeDeclaration\NodeTypeAnalyzer\DetailedTypeAnalyzer $detailedTypeAnalyzer)
    {
        $this->returnTypeInferer = $returnTypeInferer;
        $this->classMethodReturnTypeOverrideGuard = $classMethodReturnTypeOverrideGuard;
        $this->advancedArrayAnalyzer = $advancedArrayAnalyzer;
        $this->phpDocTypeChanger = $phpDocTypeChanger;
        $this->normalizeTypeToRespectArrayScalarType = $normalizeTypeToRespectArrayScalarType;
        $this->returnTagRemover = $returnTagRemover;
        $this->detailedTypeAnalyzer = $detailedTypeAnalyzer;
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        if ($this->shouldSkip($node, $phpDocInfo)) {
            return null;
        }
        $inferredReturnType = $this->returnTypeInferer->inferFunctionLikeWithExcludedInferers($node, [\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTypeDeclarationReturnTypeInferer::class]);
        $inferredReturnType = $this->normalizeTypeToRespectArrayScalarType->normalizeToArray($inferredReturnType, $node->returnType);
        if ($this->detailedTypeAnalyzer->isTooDetailed($inferredReturnType)) {
            return null;
        }
        $currentReturnType = $phpDocInfo->getReturnType();
        if ($this->classMethodReturnTypeOverrideGuard->shouldSkipClassMethodOldTypeWithNewType($currentReturnType, $inferredReturnType)) {
            return null;
        }
        if ($this->shouldSkipType($inferredReturnType, $node, $phpDocInfo)) {
            return null;
        }
        if ($inferredReturnType instanceof \PHPStan\Type\Generic\GenericObjectType && $currentReturnType instanceof \PHPStan\Type\MixedType) {
            $types = $inferredReturnType->getTypes();
            if ($types[0] instanceof \PHPStan\Type\MixedType && $types[1] instanceof \PHPStan\Type\ArrayType) {
                return null;
            }
        }
        $this->phpDocTypeChanger->changeReturnType($phpDocInfo, $inferredReturnType);
        $this->returnTagRemover->removeReturnTagIfUseless($phpDocInfo, $node);
        return $node;
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     * @param \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo
     */
    private function shouldSkip($classMethod, $phpDocInfo) : bool
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
     * @param \PHPStan\Type\Type $newType
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     * @param \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo
     */
    private function shouldSkipType($newType, $classMethod, $phpDocInfo) : bool
    {
        if ($newType instanceof \PHPStan\Type\ArrayType && $this->shouldSkipArrayType($newType, $classMethod, $phpDocInfo)) {
            return \true;
        }
        if ($this->detailedTypeAnalyzer->isTooDetailed($newType)) {
            return \true;
        }
        // not an array type
        if ($newType instanceof \PHPStan\Type\VoidType) {
            return \true;
        }
        if ($this->advancedArrayAnalyzer->isMoreSpecificArrayTypeOverride($newType, $classMethod, $phpDocInfo)) {
            return \true;
        }
        return $this->detailedTypeAnalyzer->isTooDetailed($newType);
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function shouldSkipClassMethod($classMethod) : bool
    {
        if ($this->classMethodReturnTypeOverrideGuard->shouldSkipClassMethod($classMethod)) {
            return \true;
        }
        if ($classMethod->returnType === null) {
            return \false;
        }
        return !$this->isNames($classMethod->returnType, ['array', 'iterable', 'Iterator']);
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function hasArrayShapeNode($classMethod) : bool
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
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function hasInheritDoc($classMethod) : bool
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        return $phpDocInfo->hasInheritDoc();
    }
    /**
     * @param \PHPStan\Type\ArrayType $arrayType
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     * @param \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo
     */
    private function shouldSkipArrayType($arrayType, $classMethod, $phpDocInfo) : bool
    {
        if ($this->advancedArrayAnalyzer->isNewAndCurrentTypeBothCallable($arrayType, $phpDocInfo)) {
            return \true;
        }
        if ($this->advancedArrayAnalyzer->isClassStringArrayByStringArrayOverride($arrayType, $classMethod)) {
            return \true;
        }
        return $this->advancedArrayAnalyzer->isMixedOfSpecificOverride($arrayType, $phpDocInfo);
    }
}
