<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/nette/di/pull/146/files
 *
 * @see \Rector\Nette\Tests\Rector\MethodCall\SetClassWithArgumentToSetFactoryRector\SetClassWithArgumentToSetFactoryRectorTest
 */
final class SetClassWithArgumentToSetFactoryRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change setClass with class and arguments to separated methods', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\DI\ContainerBuilder;

class SomeClass
{
    public function run(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->addDefinition('...')
            ->setClass('SomeClass', [1, 2]);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\DI\ContainerBuilder;

class SomeClass
{
    public function run(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->addDefinition('...')
            ->setFactory('SomeClass', [1, 2]);
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isName($node->name, 'setClass')) {
            return null;
        }
        if (\count((array) $node->args) !== 2) {
            return null;
        }
        if (!$this->isObjectType($node->var, '_PhpScoper0a6b37af0871\\Nette\\DI\\Definitions\\ServiceDefinition')) {
            return null;
        }
        $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier('setFactory');
        return $node;
    }
}
