<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php53\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\MagicConst\Dir;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\MagicConst\File;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php53\Tests\Rector\FuncCall\DirNameFileConstantToDirConstantRector\DirNameFileConstantToDirConstantRectorTest
 */
final class DirNameFileConstantToDirConstantRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert dirname(__FILE__) to __DIR__', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return dirname(__FILE__);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return __DIR__;
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::DIR_CONSTANT)) {
            return null;
        }
        if (!$this->isName($node, 'dirname')) {
            return null;
        }
        if (\count((array) $node->args) !== 1) {
            return null;
        }
        $firstArgValue = $node->args[0]->value;
        if (!$firstArgValue instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\MagicConst\File) {
            return null;
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\MagicConst\Dir();
    }
}
