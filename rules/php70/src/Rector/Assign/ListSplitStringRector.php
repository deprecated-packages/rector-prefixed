<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php70\Rector\Assign;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\List_;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @source http://php.net/manual/en/migration70.incompatible.php#migration70.incompatible.variable-handling.list
 *
 * @see https://stackoverflow.com/a/47965344/1348344
 * @see \Rector\Php70\Tests\Rector\Assign\ListSplitStringRector\ListSplitStringRectorTest
 */
final class ListSplitStringRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('list() cannot split string directly anymore, use str_split()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('list($foo) = "string";', 'list($foo) = str_split("string");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\List_) {
            return null;
        }
        if (!$this->isStaticType($node->expr, \_PhpScopere8e811afab72\PHPStan\Type\StringType::class)) {
            return null;
        }
        $node->expr = $this->createFuncCall('str_split', [$node->expr]);
        return $node;
    }
}
