<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\Identical;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\SimplifyArraySearchRector\SimplifyArraySearchRectorTest
 */
final class SimplifyArraySearchRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify array_search to in_array', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('array_search("searching", $array) !== false;', 'in_array("searching", $array);'), new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('array_search("searching", $array, true) !== false;', 'in_array("searching", $array, true);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($node, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            return $this->isFuncCallName($node, 'array_search');
        }, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            return $this->isFalse($node);
        });
        if ($twoNodeMatch === null) {
            return null;
        }
        /** @var FuncCall $arraySearchFuncCall */
        $arraySearchFuncCall = $twoNodeMatch->getFirstExpr();
        $inArrayFuncCall = $this->createFuncCall('in_array', $arraySearchFuncCall->args);
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($inArrayFuncCall);
        }
        return $inArrayFuncCall;
    }
}
