<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\ClassConst;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\ClassConst\VarConstantCommentRector\VarConstantCommentRectorTest
 */
final class VarConstantCommentRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var int
     */
    private const ARRAY_LIMIT_TYPES = 3;
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Constant should have a @var comment with type', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst::class];
    }
    /**
     * @param ClassConst $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (\count((array) $node->consts) > 1) {
            return null;
        }
        $constType = $this->getStaticType($node->consts[0]->value);
        if ($constType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return null;
        }
        $phpDocInfo = $this->getOrCreatePhpDocInfo($node);
        // skip big arrays and mixed[] constants
        if ($constType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            if (\count($constType->getValueTypes()) > self::ARRAY_LIMIT_TYPES) {
                return null;
            }
            $currentVarType = $phpDocInfo->getVarType();
            if ($currentVarType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType && $currentVarType->getItemType() instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
                return null;
            }
        }
        $phpDocInfo->changeVarType($constType);
        return $node;
    }
    private function getOrCreatePhpDocInfo(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst $classConst) : \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classConst->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($classConst);
        }
        return $phpDocInfo;
    }
}
