<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://symfony.com/blog/new-in-symfony-4-3-simpler-event-dispatching
 * @see \Rector\Symfony4\Tests\Rector\MethodCall\MakeDispatchFirstArgumentEventRector\MakeDispatchFirstArgumentEventRectorTest
 */
final class MakeDispatchFirstArgumentEventRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make event object a first argument of dispatch() method, event name as second', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class SomeClass
{
    public function run(EventDispatcherInterface $eventDispatcher)
    {
        $eventDispatcher->dispatch('event_name', new Event());
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class SomeClass
{
    public function run(EventDispatcherInterface $eventDispatcher)
    {
        $eventDispatcher->dispatch(new Event(), 'event_name');
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
        if ($this->shouldSkip($node)) {
            return null;
        }
        $firstArgumentValue = $node->args[0]->value;
        if ($this->isStringOrUnionStringOnlyType($firstArgumentValue)) {
            return $this->refactorStringArgument($node);
        }
        $secondArgumentValue = $node->args[1]->value;
        if ($secondArgumentValue instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return $this->refactorGetCallFuncCall($node, $secondArgumentValue, $firstArgumentValue);
        }
        return null;
    }
    private function shouldSkip(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->isObjectType($methodCall->var, '_PhpScoperb75b35f52b74\\Symfony\\Contracts\\EventDispatcher\\EventDispatcherInterface')) {
            return \true;
        }
        if (!$this->isName($methodCall->name, 'dispatch')) {
            return \true;
        }
        return !isset($methodCall->args[1]);
    }
    private function refactorStringArgument(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        // swap arguments
        [$methodCall->args[0], $methodCall->args[1]] = [$methodCall->args[1], $methodCall->args[0]];
        if ($this->isEventNameSameAsEventObjectClass($methodCall)) {
            unset($methodCall->args[1]);
        }
        return $methodCall;
    }
    private function refactorGetCallFuncCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        if ($this->isName($funcCall, 'get_class')) {
            $getClassArgumentValue = $funcCall->args[0]->value;
            if ($this->areNodesEqual($expr, $getClassArgumentValue)) {
                unset($methodCall->args[1]);
                return $methodCall;
            }
        }
        return null;
    }
    /**
     * Is the event name just `::class`?
     * We can remove it
     */
    private function isEventNameSameAsEventObjectClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$methodCall->args[1]->value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch) {
            return \false;
        }
        $classConst = $this->getValue($methodCall->args[1]->value);
        $eventStaticType = $this->getStaticType($methodCall->args[0]->value);
        if (!$eventStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $classConst === $eventStaticType->getClassName();
    }
}
