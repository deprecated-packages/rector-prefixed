<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\Identical;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/GoEPq
 * @see \Rector\CodeQuality\Tests\Rector\Identical\BooleanNotIdenticalToNotIdenticalRector\BooleanNotIdenticalToNotIdenticalRectorTest
 */
final class BooleanNotIdenticalToNotIdenticalRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Negated identical boolean compare to not identical compare (does not apply to non-bool values)', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $a = true;
        $b = false;

        var_dump(! $a === $b); // true
        var_dump(! ($a === $b)); // true
        var_dump($a !== $b); // true
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $a = true;
        $b = false;

        var_dump($a !== $b); // true
        var_dump($a !== $b); // true
        var_dump($a !== $b); // true
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot::class];
    }
    /**
     * @param Identical|BooleanNot $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical) {
            return $this->processIdentical($node);
        }
        if ($node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical) {
            $identical = $node->expr;
            if (!$this->isStaticType($identical->left, \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType::class)) {
                return null;
            }
            if (!$this->isStaticType($identical->right, \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType::class)) {
                return null;
            }
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical($identical->left, $identical->right);
        }
        return null;
    }
    private function processIdentical(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical
    {
        if (!$this->isStaticType($identical->left, \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType::class)) {
            return null;
        }
        if (!$this->isStaticType($identical->right, \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType::class)) {
            return null;
        }
        if ($identical->left instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical($identical->left->expr, $identical->right);
        }
        return null;
    }
}
