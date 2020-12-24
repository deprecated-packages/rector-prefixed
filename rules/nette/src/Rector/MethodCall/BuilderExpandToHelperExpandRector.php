<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see https://github.com/Kdyby/Doctrine/commit/db80bf77c0b68af88dfe7eddb2cb2db94aedb04a#diff-ccc8ba07edfa3a425ddfe564acb50656R291
 *
 * @see \Rector\Nette\Tests\Rector\MethodCall\BuilderExpandToHelperExpandRector\BuilderExpandToHelperExpandRectorTest
 */
final class BuilderExpandToHelperExpandRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change containerBuilder->expand() to static call with parameters', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\DI\CompilerExtension;

final class SomeClass extends CompilerExtension
{
    public function loadConfiguration()
    {
        $value = $this->getContainerBuilder()->expand('%value');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\DI\CompilerExtension;

final class SomeClass extends CompilerExtension
{
    public function loadConfiguration()
    {
        $value = \Nette\DI\Helpers::expand('%value', $this->getContainerBuilder()->parameters);
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
        if (!$this->isOnClassMethodCall($node, '_PhpScoper0a6b37af0871\\Nette\\DI\\ContainerBuilder', 'expand')) {
            return null;
        }
        $args = $node->args;
        $getContainerBuilderMethodCall = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('this'), 'getContainerBuilder');
        $parametersPropertyFetch = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch($getContainerBuilderMethodCall, 'parameters');
        $args[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($parametersPropertyFetch);
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Nette\\DI\\Helpers'), 'expand', $args);
    }
}
