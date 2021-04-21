<?php

declare(strict_types=1);

namespace Rector\CodeQuality\Rector\Identical;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BooleanNot;
use PHPStan\Type\BooleanType;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see https://3v4l.org/GoEPq
 * @see \Rector\Tests\CodeQuality\Rector\Identical\BooleanNotIdenticalToNotIdenticalRector\BooleanNotIdenticalToNotIdenticalRectorTest
 */
final class BooleanNotIdenticalToNotIdenticalRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Negated identical boolean compare to not identical compare (does not apply to non-bool values)',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
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
                    ,
                    <<<'CODE_SAMPLE'
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
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Identical::class, BooleanNot::class];
    }

    /**
     * @param Identical|BooleanNot $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if ($node instanceof Identical) {
            return $this->processIdentical($node);
        }

        if ($node->expr instanceof Identical) {
            $identical = $node->expr;
            if (! $this->nodeTypeResolver->isStaticType($identical->left, BooleanType::class)) {
                return null;
            }

            if (! $this->nodeTypeResolver->isStaticType($identical->right, BooleanType::class)) {
                return null;
            }

            return new NotIdentical($identical->left, $identical->right);
        }

        return null;
    }

    /**
     * @return \PhpParser\Node\Expr\BinaryOp\NotIdentical|null
     */
    private function processIdentical(Identical $identical)
    {
        if (! $this->nodeTypeResolver->isStaticType($identical->left, BooleanType::class)) {
            return null;
        }

        if (! $this->nodeTypeResolver->isStaticType($identical->right, BooleanType::class)) {
            return null;
        }

        if ($identical->left instanceof BooleanNot) {
            return new NotIdentical($identical->left->expr, $identical->right);
        }

        return null;
    }
}
