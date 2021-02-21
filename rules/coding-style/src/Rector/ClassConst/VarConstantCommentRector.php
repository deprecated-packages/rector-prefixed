<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\ClassConst;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassConst;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\MixedType;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\PHPStan\TypeComparator;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\ClassConst\VarConstantCommentRector\VarConstantCommentRectorTest
 */
final class VarConstantCommentRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var int
     */
    private const ARRAY_LIMIT_TYPES = 3;
    /**
     * @var TypeComparator
     */
    private $typeComparator;
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    public function __construct(\Rector\NodeTypeResolver\PHPStan\TypeComparator $typeComparator, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger)
    {
        $this->typeComparator = $typeComparator;
        $this->phpDocTypeChanger = $phpDocTypeChanger;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Constant should have a @var comment with type', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    const HI = 'hi';
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var string
     */
    const HI = 'hi';
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassConst::class];
    }
    /**
     * @param ClassConst $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (\count($node->consts) > 1) {
            return null;
        }
        $constType = $this->getStaticType($node->consts[0]->value);
        if ($constType instanceof \PHPStan\Type\MixedType) {
            return null;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
        // skip big arrays and mixed[] constants
        if ($constType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            if (\count($constType->getValueTypes()) > self::ARRAY_LIMIT_TYPES) {
                return null;
            }
            $currentVarType = $phpDocInfo->getVarType();
            if ($currentVarType instanceof \PHPStan\Type\ArrayType && $currentVarType->getItemType() instanceof \PHPStan\Type\MixedType) {
                return null;
            }
            if ($this->hasTwoAndMoreGenericClassStringTypes($constType)) {
                return null;
            }
        }
        if ($this->typeComparator->isSubtype($constType, $phpDocInfo->getVarType())) {
            return null;
        }
        $this->phpDocTypeChanger->changeVarType($phpDocInfo, $constType);
        return $node;
    }
    private function hasTwoAndMoreGenericClassStringTypes(\PHPStan\Type\Constant\ConstantArrayType $constantArrayType) : bool
    {
        $typeNode = $this->staticTypeMapper->mapPHPStanTypeToPHPStanPhpDocTypeNode($constantArrayType);
        if (!$typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode) {
            return \false;
        }
        if (!$typeNode->type instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return \false;
        }
        $genericTypeNodeCount = 0;
        foreach ($typeNode->type->types as $unionedTypeNode) {
            if ($unionedTypeNode instanceof \PHPStan\PhpDocParser\Ast\Type\GenericTypeNode) {
                ++$genericTypeNodeCount;
            }
        }
        return $genericTypeNodeCount > 1;
    }
}
