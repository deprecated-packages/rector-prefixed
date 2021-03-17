<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\BinaryOp;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\Instanceof_;
use PhpParser\Node\Expr\Variable;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\DeadCode\Rector\BinaryOp\RemoveDuplicatedInstanceOfRector\RemoveDuplicatedInstanceOfRectorTest
 */
final class RemoveDuplicatedInstanceOfRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private $duplicatedInstanceOfs = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove duplicated instanceof in one call', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        $isIt = $value instanceof A || $value instanceof A;
        $isIt = $value instanceof A && $value instanceof A;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value): void
    {
        $isIt = $value instanceof A;
        $isIt = $value instanceof A;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\BinaryOp::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        $this->resolveDuplicatedInstancesOf($node);
        if ($this->duplicatedInstanceOfs === []) {
            return null;
        }
        return $this->traverseBinaryOpAndRemoveDuplicatedInstanceOfs($node);
    }
    /**
     * @param \PhpParser\Node\Expr\BinaryOp $binaryOp
     */
    private function resolveDuplicatedInstancesOf($binaryOp) : void
    {
        $this->duplicatedInstanceOfs = [];
        /** @var Instanceof_[] $instanceOfs */
        $instanceOfs = $this->betterNodeFinder->findInstanceOf([$binaryOp], \PhpParser\Node\Expr\Instanceof_::class);
        $instanceOfsByClass = [];
        foreach ($instanceOfs as $instanceOf) {
            $variableClassKey = $this->createUniqueKeyForInstanceOf($instanceOf);
            if ($variableClassKey === null) {
                continue;
            }
            $instanceOfsByClass[$variableClassKey][] = $instanceOf;
        }
        foreach ($instanceOfsByClass as $variableClassKey => $instanceOfs) {
            if (\count($instanceOfs) < 2) {
                unset($instanceOfsByClass[$variableClassKey]);
            }
        }
        $this->duplicatedInstanceOfs = \array_keys($instanceOfsByClass);
    }
    /**
     * @param \PhpParser\Node\Expr\BinaryOp $binaryOp
     */
    private function traverseBinaryOpAndRemoveDuplicatedInstanceOfs($binaryOp) : \PhpParser\Node
    {
        $this->traverseNodesWithCallable([&$binaryOp], function (\PhpParser\Node $node) : ?Node {
            if (!$node instanceof \PhpParser\Node\Expr\BinaryOp) {
                return null;
            }
            if ($node->left instanceof \PhpParser\Node\Expr\Instanceof_) {
                return $this->processBinaryWithFirstInstaneOf($node->left, $node->right);
            }
            if ($node->right instanceof \PhpParser\Node\Expr\Instanceof_) {
                return $this->processBinaryWithFirstInstaneOf($node->right, $node->left);
            }
            return null;
        });
        return $binaryOp;
    }
    /**
     * @param \PhpParser\Node\Expr\Instanceof_ $instanceof
     */
    private function createUniqueKeyForInstanceOf($instanceof) : ?string
    {
        if (!$instanceof->expr instanceof \PhpParser\Node\Expr\Variable) {
            return null;
        }
        $variableName = $this->getName($instanceof->expr);
        if ($variableName === null) {
            return null;
        }
        $className = $this->getName($instanceof->class);
        if ($className === null) {
            return null;
        }
        return $variableName . '_' . $className;
    }
    /**
     * @param \PhpParser\Node\Expr\Instanceof_ $instanceof
     * @param \PhpParser\Node\Expr $otherExpr
     */
    private function processBinaryWithFirstInstaneOf($instanceof, $otherExpr) : ?\PhpParser\Node\Expr
    {
        $variableClassKey = $this->createUniqueKeyForInstanceOf($instanceof);
        if (!\in_array($variableClassKey, $this->duplicatedInstanceOfs, \true)) {
            return null;
        }
        // remove just once
        $this->removeClassFromDuplicatedInstanceOfs($variableClassKey);
        // remove left instanceof
        return $otherExpr;
    }
    /**
     * @param string $variableClassKey
     */
    private function removeClassFromDuplicatedInstanceOfs($variableClassKey) : void
    {
        // remove just once
        unset($this->duplicatedInstanceOfs[\array_search($variableClassKey, $this->duplicatedInstanceOfs, \true)]);
    }
}
