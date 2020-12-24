<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadDocBlock\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DeadDocBlock\DeadParamTagValueNodeAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadDocBlock\Tests\Rector\ClassMethod\RemoveUselessParamTagRector\RemoveUselessParamTagRectorTest
 */
final class RemoveUselessParamTagRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var DeadParamTagValueNodeAnalyzer
     */
    private $deadParamTagValueNodeAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\DeadDocBlock\DeadParamTagValueNodeAnalyzer $deadParamTagValueNodeAnalyzer)
    {
        $this->deadParamTagValueNodeAnalyzer = $deadParamTagValueNodeAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove @param docblock with same type as parameter type', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param string $a
     * @param string $b description
     */
    public function foo(string $a, string $b)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param string $b description
     */
    public function foo(string $a, string $b)
    {
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $phpDocInfo = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return null;
        }
        $hasChanged = \false;
        foreach ($phpDocInfo->getParamTagValueNodes() as $paramTagValueNode) {
            if (!$this->deadParamTagValueNodeAnalyzer->isDead($paramTagValueNode, $node)) {
                continue;
            }
            $phpDocInfo->removeTagValueNodeFromNode($paramTagValueNode);
            $hasChanged = \true;
        }
        if (!$hasChanged) {
            return null;
        }
        return $node;
    }
}
