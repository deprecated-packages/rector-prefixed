<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\PropertyProperty;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use function strtolower;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\PropertyProperty\RemoveNullPropertyInitializationRector\RemoveNullPropertyInitializationRectorTest
 */
final class RemoveNullPropertyInitializationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove initialization with null value from property declarations', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SunshineCommand extends ParentClassWithNewConstructor
{
    private $myVar = null;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SunshineCommand extends ParentClassWithNewConstructor
{
    private $myVar;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\PropertyProperty::class];
    }
    /**
     * @param PropertyProperty $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $defaultValueNode = $node->default;
        if ($defaultValueNode === null) {
            return null;
        }
        if (!$defaultValueNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch) {
            return null;
        }
        if (\strtolower((string) $defaultValueNode->name) !== 'null') {
            return null;
        }
        $nodeNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if ($nodeNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
            return null;
        }
        $node->default = null;
        return $node;
    }
}
