<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\Ternary;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Ternary\SimplifyDuplicatedTernaryRector\SimplifyDuplicatedTernaryRectorTest
 */
final class SimplifyDuplicatedTernaryRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove ternary that duplicated return value of true : false', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(bool $value, string $name)
    {
         $isTrue = $value ? true : false;
         $isName = $name ? true : false;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(bool $value, string $name)
    {
         $isTrue = $value;
         $isName = $name ? true : false;
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isStaticType($node->cond, \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType::class)) {
            return null;
        }
        if ($node->if === null) {
            return null;
        }
        if (!$this->isTrue($node->if) || !$this->isFalse($node->else)) {
            return null;
        }
        return $node->cond;
    }
}
