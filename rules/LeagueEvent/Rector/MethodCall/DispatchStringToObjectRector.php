<?php

namespace Rector\LeagueEvent\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\LeagueEvent\Rector\MethodCall\DispatchStringToObjectRector\DispatchStringToObjectRectorTest
 */
final class DispatchStringToObjectRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change string events to anonymous class which implement \\League\\Event\\HasEventName', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    /** @var \League\Event\EventDispatcher */
    private $dispatcher;

    public function run()
    {
        $this->dispatcher->dispatch('my-event');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    /** @var \League\Event\EventDispatcher */
    private $dispatcher;

    public function run()
    {
        $this->dispatcher->dispatch(new class implements \League\Event\HasEventName
        {
            public function eventName(): string
            {
                return 'my-event';
            }
        });
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Expr>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        return $this->updateNode($node);
    }
    private function shouldSkip(\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->isNames($methodCall->name, ['dispatch', 'emit'])) {
            return \true;
        }
        return !$this->nodeTypeResolver->isObjectTypes($methodCall->var, [new \PHPStan\Type\ObjectType('League\\Event\\EventDispatcher'), new \PHPStan\Type\ObjectType('League\\Event\\Emitter')]);
    }
    private function updateNode(\PhpParser\Node\Expr\MethodCall $methodCall) : \PhpParser\Node\Expr\MethodCall
    {
        $methodCall->args[0] = new \PhpParser\Node\Arg($this->createNewAnonymousEventClass($methodCall->args[0]->value));
        return $methodCall;
    }
    private function createNewAnonymousEventClass(\PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr\New_
    {
        $implements = [new \PhpParser\Node\Name\FullyQualified('League\\Event\\HasEventName')];
        return new \PhpParser\Node\Expr\New_(new \PhpParser\Node\Stmt\Class_(null, ['implements' => $implements, 'stmts' => $this->createAnonymousEventClassBody($expr)]));
    }
    /**
     * @return Stmt[]
     */
    private function createAnonymousEventClassBody(\PhpParser\Node\Expr $expr) : array
    {
        return [new \PhpParser\Node\Stmt\ClassMethod('eventName', ['flags' => \PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC, 'returnType' => 'string', 'stmts' => [new \PhpParser\Node\Stmt\Return_($expr)]])];
    }
}
