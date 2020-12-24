<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php70\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php70\Tests\Rector\FuncCall\MultiDirnameRector\MultiDirnameRectorTest
 */
final class MultiDirnameRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const DIRNAME = 'dirname';
    /**
     * @var int
     */
    private $nestingLevel = 0;
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes multiple dirname() calls to one with nesting level', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('dirname(dirname($path));', 'dirname($path, 2);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::DIRNAME_LEVELS)) {
            return null;
        }
        $this->nestingLevel = 0;
        if (!$this->isName($node, self::DIRNAME)) {
            return null;
        }
        $activeFuncCallNode = $node;
        $lastFuncCallNode = $node;
        while ($activeFuncCallNode = $this->matchNestedDirnameFuncCall($activeFuncCallNode)) {
            $lastFuncCallNode = $activeFuncCallNode;
        }
        // nothing to improve
        if ($this->nestingLevel < 2) {
            return $activeFuncCallNode;
        }
        $node->args[0] = $lastFuncCallNode->args[0];
        $node->args[1] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber($this->nestingLevel));
        return $node;
    }
    private function matchNestedDirnameFuncCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall
    {
        if (!$this->isName($funcCall, self::DIRNAME)) {
            return null;
        }
        if (\count((array) $funcCall->args) >= 3) {
            return null;
        }
        // dirname($path, <LEVEL>);
        if (\count((array) $funcCall->args) === 2) {
            if (!$funcCall->args[1]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber) {
                return null;
            }
            /** @var LNumber $levelNumber */
            $levelNumber = $funcCall->args[1]->value;
            $this->nestingLevel += $levelNumber->value;
        } else {
            ++$this->nestingLevel;
        }
        $nestedFuncCallNode = $funcCall->args[0]->value;
        if (!$nestedFuncCallNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        if ($this->isName($nestedFuncCallNode, self::DIRNAME)) {
            return $nestedFuncCallNode;
        }
        return null;
    }
}
