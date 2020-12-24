<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see https://github.com/Kdyby/Doctrine/commit/db80bf77c0b68af88dfe7eddb2cb2db94aedb04a#diff-ccc8ba07edfa3a425ddfe564acb50656R291
 *
 * @see \Rector\Nette\Tests\Rector\MethodCall\BuilderExpandToHelperExpandRector\BuilderExpandToHelperExpandRectorTest
 */
final class BuilderExpandToHelperExpandRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change containerBuilder->expand() to static call with parameters', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isOnClassMethodCall($node, '_PhpScoperb75b35f52b74\\Nette\\DI\\ContainerBuilder', 'expand')) {
            return null;
        }
        $args = $node->args;
        $getContainerBuilderMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), 'getContainerBuilder');
        $parametersPropertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch($getContainerBuilderMethodCall, 'parameters');
        $args[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($parametersPropertyFetch);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\Nette\\DI\\Helpers'), 'expand', $args);
    }
}
