<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php72\Rector\Assign;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\List_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @source https://wiki.php.net/rfc/deprecations_php_7_2#each
 *
 * @see \Rector\Php72\Tests\Rector\Assign\ListEachRector\ListEachRectorTest
 */
final class ListEachRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AssignManipulator
     */
    private $assignManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator)
    {
        $this->assignManipulator = $assignManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('each() function is deprecated, use key() and current() instead', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
list($key, $callback) = each($callbacks);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$key = key($callbacks);
$callback = current($callbacks);
next($callbacks);
CODE_SAMPLE
)]);
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
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var List_ $listNode */
        $listNode = $node->var;
        /** @var FuncCall $eachFuncCall */
        $eachFuncCall = $node->expr;
        // only key: list($key, ) = each($values);
        if ($listNode->items[0] && $listNode->items[1] === null) {
            $keyFuncCall = $this->createFuncCall('key', $eachFuncCall->args);
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($listNode->items[0]->value, $keyFuncCall);
        }
        // only value: list(, $value) = each($values);
        if ($listNode->items[1] && $listNode->items[0] === null) {
            $nextFuncCall = $this->createFuncCall('next', $eachFuncCall->args);
            $this->addNodeAfterNode($nextFuncCall, $node);
            $currentFuncCall = $this->createFuncCall('current', $eachFuncCall->args);
            $secondArrayItem = $listNode->items[1];
            if (!$secondArrayItem instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($secondArrayItem->value, $currentFuncCall);
        }
        // both: list($key, $value) = each($values);
        // ↓
        // $key = key($values);
        // $value = current($values);
        // next($values);
        $currentFuncCall = $this->createFuncCall('current', $eachFuncCall->args);
        $secondArrayItem = $listNode->items[1];
        if (!$secondArrayItem instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($secondArrayItem->value, $currentFuncCall);
        $this->addNodeAfterNode($assign, $node);
        $nextFuncCall = $this->createFuncCall('next', $eachFuncCall->args);
        $this->addNodeAfterNode($nextFuncCall, $node);
        $keyFuncCall = $this->createFuncCall('key', $eachFuncCall->args);
        $firstArrayItem = $listNode->items[0];
        if (!$firstArrayItem instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($firstArrayItem->value, $keyFuncCall);
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : bool
    {
        if (!$this->assignManipulator->isListToEachAssign($assign)) {
            return \true;
        }
        // assign should be top level, e.g. not in a while loop
        $parentNode = $assign->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
            return \true;
        }
        /** @var List_ $listNode */
        $listNode = $assign->var;
        if (\count((array) $listNode->items) !== 2) {
            return \true;
        }
        // empty list → cannot handle
        if ($listNode->items[0] !== null) {
            return \false;
        }
        return $listNode->items[1] === null;
    }
}
