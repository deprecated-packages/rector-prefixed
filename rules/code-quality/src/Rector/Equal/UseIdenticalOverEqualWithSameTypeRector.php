<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\Equal;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotEqual;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector\UseIdenticalOverEqualWithSameTypeRectorTest
 */
final class UseIdenticalOverEqualWithSameTypeRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use ===/!== over ==/!=, it values have the same type', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(int $firstValue, int $secondValue)
    {
         $isSame = $firstValue == $secondValue;
         $isDiffernt = $firstValue != $secondValue;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(int $firstValue, int $secondValue)
    {
         $isSame = $firstValue === $secondValue;
         $isDiffernt = $firstValue !== $secondValue;
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotEqual::class];
    }
    /**
     * @param Equal|NotEqual $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $leftStaticType = $this->getStaticType($node->left);
        $rightStaticType = $this->getStaticType($node->right);
        // objects can be different by content
        if ($leftStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
            return null;
        }
        if ($leftStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType || $rightStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return null;
        }
        // different types
        if (!$leftStaticType->equals($rightStaticType)) {
            return null;
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical($node->left, $node->right);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical($node->left, $node->right);
    }
}
