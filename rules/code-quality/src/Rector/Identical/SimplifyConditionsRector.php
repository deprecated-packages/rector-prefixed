<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\Identical;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\AssignAndBinaryMap;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\SimplifyConditionsRector\SimplifyConditionsRectorTest
 */
final class SimplifyConditionsRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AssignAndBinaryMap
     */
    private $assignAndBinaryMap;
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\AssignAndBinaryMap $assignAndBinaryMap, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->assignAndBinaryMap = $assignAndBinaryMap;
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify conditions', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample("if (! (\$foo !== 'bar')) {...", "if (\$foo === 'bar') {...")]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param BooleanNot|Identical $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot) {
            return $this->processBooleanNot($node);
        }
        return $this->processIdenticalAndNotIdentical($node);
    }
    private function processBooleanNot(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot $booleanNot) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$booleanNot->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp) {
            return null;
        }
        if ($this->shouldSkip($booleanNot->expr)) {
            return null;
        }
        return $this->createInversedBooleanOp($booleanNot->expr);
    }
    private function processIdenticalAndNotIdentical(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($identical, function (\_PhpScoper0a6b37af0871\PhpParser\Node $binaryOp) : bool {
            return $binaryOp instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical || $binaryOp instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
        }, function (\_PhpScoper0a6b37af0871\PhpParser\Node $binaryOp) : bool {
            return $this->isBool($binaryOp);
        });
        if ($twoNodeMatch === null) {
            return $twoNodeMatch;
        }
        /** @var Identical|NotIdentical $subBinaryOp */
        $subBinaryOp = $twoNodeMatch->getFirstExpr();
        $otherNode = $twoNodeMatch->getSecondExpr();
        if ($this->isFalse($otherNode)) {
            return $this->createInversedBooleanOp($subBinaryOp);
        }
        return $subBinaryOp;
    }
    /**
     * Skip too nested binary || binary > binary combinations
     */
    private function shouldSkip(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp $binaryOp) : bool
    {
        if ($binaryOp instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return \true;
        }
        if ($binaryOp->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp) {
            return \true;
        }
        return $binaryOp->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
    }
    private function createInversedBooleanOp(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp
    {
        $inversedBinaryClass = $this->assignAndBinaryMap->getInversed($binaryOp);
        if ($inversedBinaryClass === null) {
            return null;
        }
        return new $inversedBinaryClass($binaryOp->left, $binaryOp->right);
    }
}
