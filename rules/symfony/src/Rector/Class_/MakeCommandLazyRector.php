<?php

declare (strict_types=1);
namespace Rector\Symfony\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PHPStan\Type\StringType;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://symfony.com/doc/current/console/commands_as_services.html
 * @sponsor Thanks https://www.musement.com/ for sponsoring this rule; initiated by https://github.com/stloyd
 *
 * @see \Rector\Symfony\Tests\Rector\Class_\MakeCommandLazyRector\MakeCommandLazyRectorTest
 */
final class MakeCommandLazyRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make Symfony commands lazy', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isObjectType($node, 'Symfony\\Component\\Console\\Command\\Command')) {
            return null;
        }
        $commandName = $this->resolveCommandNameAndRemove($node);
        if (!$commandName instanceof \PhpParser\Node) {
            return null;
        }
        $defaultNameProperty = $this->nodeFactory->createStaticProtectedPropertyWithDefault('defaultName', $commandName);
        $node->stmts = \array_merge([$defaultNameProperty], $node->stmts);
        return $node;
    }
    private function resolveCommandNameAndRemove(\PhpParser\Node\Stmt\Class_ $class) : ?\PhpParser\Node
    {
        $commandName = $this->resolveCommandNameFromConstructor($class);
        if (!$commandName instanceof \PhpParser\Node) {
            $commandName = $this->resolveCommandNameFromSetName($class);
        }
        $this->removeConstructorIfHasOnlySetNameMethodCall($class);
        return $commandName;
    }
    private function resolveCommandNameFromConstructor(\PhpParser\Node\Stmt\Class_ $class) : ?\PhpParser\Node
    {
        $commandName = null;
        $this->traverseNodesWithCallable($class->stmts, function (\PhpParser\Node $node) use(&$commandName) {
            if (!$node instanceof \PhpParser\Node\Expr\StaticCall) {
                return null;
            }
            if (!$this->isObjectType($node->class, 'Symfony\\Component\\Console\\Command\\Command')) {
                return null;
            }
            $commandName = $this->matchCommandNameNodeInConstruct($node);
            if (!$commandName instanceof \PhpParser\Node\Expr) {
                return null;
            }
            \array_shift($node->args);
        });
        return $commandName;
    }
    private function resolveCommandNameFromSetName(\PhpParser\Node\Stmt\Class_ $class) : ?\PhpParser\Node
    {
        $commandName = null;
        $this->traverseNodesWithCallable($class->stmts, function (\PhpParser\Node $node) use(&$commandName) {
            if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->isObjectType($node->var, 'Symfony\\Component\\Console\\Command\\Command')) {
                return null;
            }
            if (!$this->isName($node->name, 'setName')) {
                return null;
            }
            $commandName = $node->args[0]->value;
            $commandNameStaticType = $this->getStaticType($commandName);
            if (!$commandNameStaticType instanceof \PHPStan\Type\StringType) {
                return null;
            }
            // is chain call? → remove by variable nulling
            if ($node->var instanceof \PhpParser\Node\Expr\MethodCall) {
                return $node->var;
            }
            $this->removeNode($node);
        });
        return $commandName;
    }
    private function removeConstructorIfHasOnlySetNameMethodCall(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $constructClassMethod = $class->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        if (!$constructClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return;
        }
        $stmts = (array) $constructClassMethod->stmts;
        if (\count($stmts) !== 1) {
            return;
        }
        $onlyNode = $stmts[0];
        if ($onlyNode instanceof \PhpParser\Node\Stmt\Expression) {
            $onlyNode = $onlyNode->expr;
        }
        /** @var Expr|null $onlyNode */
        if ($onlyNode === null) {
            return;
        }
        if (!$onlyNode instanceof \PhpParser\Node\Expr\StaticCall) {
            return;
        }
        if ($onlyNode->args !== []) {
            return;
        }
        $this->removeNode($constructClassMethod);
    }
    private function matchCommandNameNodeInConstruct(\PhpParser\Node\Expr\StaticCall $staticCall) : ?\PhpParser\Node\Expr
    {
        if (!$this->isName($staticCall->name, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
            return null;
        }
        if (\count($staticCall->args) < 1) {
            return null;
        }
        $staticType = $this->getStaticType($staticCall->args[0]->value);
        if (!$staticType instanceof \PHPStan\Type\StringType) {
            return null;
        }
        return $staticCall->args[0]->value;
    }
}
