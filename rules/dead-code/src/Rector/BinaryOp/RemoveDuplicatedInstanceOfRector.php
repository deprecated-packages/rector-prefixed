<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Rector\BinaryOp;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\BinaryOp\RemoveDuplicatedInstanceOfRector\RemoveDuplicatedInstanceOfRectorTest
 */
final class RemoveDuplicatedInstanceOfRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private $duplicatedInstanceOfs = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove duplicated instanceof in one call', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp::class];
    }
    /**
     * @param BinaryOp $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $this->resolveDuplicatedInstancesOf($node);
        if ($this->duplicatedInstanceOfs === []) {
            return null;
        }
        return $this->traverseBinaryOpAndRemoveDuplicatedInstanceOfs($node);
    }
    private function resolveDuplicatedInstancesOf(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : void
    {
        $this->duplicatedInstanceOfs = [];
        /** @var Instanceof_[] $instanceOfs */
        $instanceOfs = $this->betterNodeFinder->findInstanceOf([$binaryOp], \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_::class);
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
    private function traverseBinaryOpAndRemoveDuplicatedInstanceOfs(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $this->traverseNodesWithCallable([&$binaryOp], function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?Node {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp) {
                return null;
            }
            if ($node->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_) {
                return $this->processBinaryWithFirstInstaneOf($node->left, $node->right);
            }
            if ($node->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_) {
                return $this->processBinaryWithFirstInstaneOf($node->right, $node->left);
            }
            return null;
        });
        return $binaryOp;
    }
    private function createUniqueKeyForInstanceOf(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_ $instanceof) : ?string
    {
        if (!$instanceof->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
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
    private function processBinaryWithFirstInstaneOf(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_ $instanceof, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $otherExpr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
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
    private function removeClassFromDuplicatedInstanceOfs(string $variableClassKey) : void
    {
        // remove just once
        unset($this->duplicatedInstanceOfs[\array_search($variableClassKey, $this->duplicatedInstanceOfs, \true)]);
    }
}
