<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://symfony.com/doc/current/console/commands_as_services.html
 * @sponsor Thanks https://www.musement.com/ for sponsoring this rule; initiated by https://github.com/stloyd
 *
 * @see \Rector\Symfony\Tests\Rector\Class_\MakeCommandLazyRector\MakeCommandLazyRectorTest
 */
final class MakeCommandLazyRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make Symfony commands lazy', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Console\Command\Command

class SunshineCommand extends Command
{
    public function configure()
    {
        $this->setName('sunshine');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Console\Command\Command

class SunshineCommand extends Command
{
    protected static $defaultName = 'sunshine';
    public function configure()
    {
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScoper0a6b37af0871\\Symfony\\Component\\Console\\Command\\Command')) {
            return null;
        }
        $commandName = $this->resolveCommandNameAndRemove($node);
        if ($commandName === null) {
            return null;
        }
        $defaultNameProperty = $this->nodeFactory->createStaticProtectedPropertyWithDefault('defaultName', $commandName);
        $node->stmts = \array_merge([$defaultNameProperty], (array) $node->stmts);
        return $node;
    }
    private function resolveCommandNameAndRemove(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $commandName = $this->resolveCommandNameFromConstructor($class);
        if ($commandName === null) {
            $commandName = $this->resolveCommandNameFromSetName($class);
        }
        $this->removeConstructorIfHasOnlySetNameMethodCall($class);
        return $commandName;
    }
    private function resolveCommandNameFromConstructor(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $commandName = null;
        $this->traverseNodesWithCallable((array) $class->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$commandName) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
                return null;
            }
            if (!$this->isObjectType($node->class, '_PhpScoper0a6b37af0871\\Symfony\\Component\\Console\\Command\\Command')) {
                return null;
            }
            $commandName = $this->matchCommandNameNodeInConstruct($node);
            if ($commandName === null) {
                return null;
            }
            \array_shift($node->args);
        });
        return $commandName;
    }
    private function resolveCommandNameFromSetName(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $commandName = null;
        $this->traverseNodesWithCallable((array) $class->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$commandName) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->isObjectType($node->var, '_PhpScoper0a6b37af0871\\Symfony\\Component\\Console\\Command\\Command')) {
                return null;
            }
            if (!$this->isName($node->name, 'setName')) {
                return null;
            }
            $commandName = $node->args[0]->value;
            $commandNameStaticType = $this->getStaticType($commandName);
            if (!$commandNameStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType) {
                return null;
            }
            // is chain call? → remove by variable nulling
            if ($node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
                return $node->var;
            }
            $this->removeNode($node);
        });
        return $commandName;
    }
    private function removeConstructorIfHasOnlySetNameMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $constructClassMethod = $class->getMethod(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if ($constructClassMethod === null) {
            return;
        }
        $stmts = (array) $constructClassMethod->stmts;
        if (\count($stmts) !== 1) {
            return;
        }
        $onlyNode = $stmts[0];
        if ($onlyNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
            $onlyNode = $onlyNode->expr;
        }
        /** @var Expr|null $onlyNode */
        if ($onlyNode === null) {
            return;
        }
        if (!$onlyNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            return;
        }
        if ($onlyNode->args !== []) {
            return;
        }
        $this->removeNode($constructClassMethod);
    }
    private function matchCommandNameNodeInConstruct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if (!$this->isName($staticCall->name, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return null;
        }
        if (\count((array) $staticCall->args) < 1) {
            return null;
        }
        $staticType = $this->getStaticType($staticCall->args[0]->value);
        if (!$staticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType) {
            return null;
        }
        return $staticCall->args[0]->value;
    }
}
