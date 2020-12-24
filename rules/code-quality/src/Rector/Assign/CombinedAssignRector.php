<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\Assign;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\AssignAndBinaryMap;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Assign\CombinedAssignRector\CombinedAssignRectorTest
 */
final class CombinedAssignRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AssignAndBinaryMap
     */
    private $assignAndBinaryMap;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\AssignAndBinaryMap $assignAndBinaryMap)
    {
        $this->assignAndBinaryMap = $assignAndBinaryMap;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify $value = $value + 5; assignments to shorter ones', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$value = $value + 5;', '$value += 5;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp) {
            return null;
        }
        /** @var BinaryOp $binaryNode */
        $binaryNode = $node->expr;
        if (!$this->areNodesEqual($node->var, $binaryNode->left)) {
            return null;
        }
        $assignClass = $this->assignAndBinaryMap->getAlternative($binaryNode);
        if ($assignClass === null) {
            return null;
        }
        return new $assignClass($node->var, $binaryNode->right);
    }
}
