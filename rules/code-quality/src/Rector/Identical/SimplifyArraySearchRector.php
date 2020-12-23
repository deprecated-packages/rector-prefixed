<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\Identical;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\SimplifyArraySearchRector\SimplifyArraySearchRectorTest
 */
final class SimplifyArraySearchRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify array_search to in_array', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('array_search("searching", $array) !== false;', 'in_array("searching", $array);'), new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('array_search("searching", $array, true) !== false;', 'in_array("searching", $array, true);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($node, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            return $this->isFuncCallName($node, 'array_search');
        }, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            return $this->isFalse($node);
        });
        if ($twoNodeMatch === null) {
            return null;
        }
        /** @var FuncCall $arraySearchFuncCall */
        $arraySearchFuncCall = $twoNodeMatch->getFirstExpr();
        $inArrayFuncCall = $this->createFuncCall('in_array', $arraySearchFuncCall->args);
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot($inArrayFuncCall);
        }
        return $inArrayFuncCall;
    }
}
