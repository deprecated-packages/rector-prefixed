<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\Rector\BinaryOp;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Instanceof_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\BinaryOp\RemoveDuplicatedInstanceOfRector\RemoveDuplicatedInstanceOfRectorTest
 */
final class RemoveDuplicatedInstanceOfRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private $duplicatedInstanceOfs = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove duplicated instanceof in one call', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp::class];
    }
    /**
     * @param BinaryOp $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $this->resolveDuplicatedInstancesOf($node);
        if ($this->duplicatedInstanceOfs === []) {
            return null;
        }
        return $this->traverseBinaryOpAndRemoveDuplicatedInstanceOfs($node);
    }
    private function resolveDuplicatedInstancesOf(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp $binaryOp) : void
    {
        $this->duplicatedInstanceOfs = [];
        /** @var Instanceof_[] $instanceOfs */
        $instanceOfs = $this->betterNodeFinder->findInstanceOf([$binaryOp], \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Instanceof_::class);
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
    private function traverseBinaryOpAndRemoveDuplicatedInstanceOfs(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp $binaryOp) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $this->traverseNodesWithCallable([&$binaryOp], function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?Node {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp) {
                return null;
            }
            if ($node->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Instanceof_) {
                return $this->processBinaryWithFirstInstaneOf($node->left, $node->right);
            }
            if ($node->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Instanceof_) {
                return $this->processBinaryWithFirstInstaneOf($node->right, $node->left);
            }
            return null;
        });
        return $binaryOp;
    }
    private function createUniqueKeyForInstanceOf(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Instanceof_ $instanceof) : ?string
    {
        if (!$instanceof->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
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
    private function processBinaryWithFirstInstaneOf(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Instanceof_ $instanceof, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $otherExpr) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
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
