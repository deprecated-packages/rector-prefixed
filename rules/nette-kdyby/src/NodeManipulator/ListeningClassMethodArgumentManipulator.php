<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\NodeManipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NetteKdyby\ContributeEventClassResolver;
use _PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use _PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\EventClassAndClassMethod;
use _PhpScopere8e811afab72\Symfony\Contracts\EventDispatcher\Event;
final class ListeningClassMethodArgumentManipulator
{
    /**
     * @var string
     */
    private const EVENT_PARAMETER_REPLACED = 'event_parameter_replaced';
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var ContributeEventClassResolver
     */
    private $contributeEventClassResolver;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScopere8e811afab72\Rector\NetteKdyby\ContributeEventClassResolver $contributeEventClassResolver)
    {
        $this->classNaming = $classNaming;
        $this->contributeEventClassResolver = $contributeEventClassResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function changeFromEventAndListenerTreeAndCurrentClassName(\_PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree, string $className) : void
    {
        $listenerClassMethods = $eventAndListenerTree->getListenerClassMethodsByClass($className);
        if ($listenerClassMethods === []) {
            return;
        }
        $classMethodsByEventClass = [];
        foreach ($listenerClassMethods as $listenerClassMethod) {
            $classMethodsByEventClass[] = new \_PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\EventClassAndClassMethod($className, $listenerClassMethod);
        }
        $this->change($classMethodsByEventClass, $eventAndListenerTree);
    }
    /**
     * @param EventClassAndClassMethod[] $classMethodsByEventClass
     */
    public function change(array $classMethodsByEventClass, ?\_PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : void
    {
        foreach ($classMethodsByEventClass as $eventClassAndClassMethod) {
            // are attributes already replaced
            $classMethod = $eventClassAndClassMethod->getClassMethod();
            $eventParameterReplaced = $classMethod->getAttribute(self::EVENT_PARAMETER_REPLACED);
            if ($eventParameterReplaced) {
                continue;
            }
            $oldParams = $classMethod->params;
            $eventClass = $eventAndListenerTree !== null ? $eventAndListenerTree->getEventClassName() : $eventClassAndClassMethod->getEventClass();
            $this->changeClassParamToEventClass($eventClass, $classMethod);
            // move params to getter on event
            foreach ($oldParams as $oldParam) {
                if (!$this->isParamUsedInClassMethodBody($classMethod, $oldParam)) {
                    continue;
                }
                $eventGetterToVariableAssign = $this->createEventGetterToVariableMethodCall($eventClass, $oldParam, $eventAndListenerTree);
                $expression = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($eventGetterToVariableAssign);
                $classMethod->stmts = \array_merge([$expression], (array) $classMethod->stmts);
            }
            $classMethod->setAttribute(self::EVENT_PARAMETER_REPLACED, \true);
        }
    }
    private function changeClassParamToEventClass(string $eventClass, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $paramName = $this->classNaming->getVariableName($eventClass);
        $eventVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($paramName);
        $param = new \_PhpScopere8e811afab72\PhpParser\Node\Param($eventVariable, null, new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($eventClass));
        $classMethod->params = [$param];
    }
    private function isParamUsedInClassMethodBody(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PhpParser\Node\Param $param) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($param) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->betterStandardPrinter->areNodesEqual($node, $param->var);
        });
    }
    private function createEventGetterToVariableMethodCall(string $eventClass, \_PhpScopere8e811afab72\PhpParser\Node\Param $param, ?\_PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign
    {
        $paramName = $this->classNaming->getVariableName($eventClass);
        $eventVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($paramName);
        $getterMethod = $this->contributeEventClassResolver->resolveGetterMethodByEventClassAndParam($eventClass, $param, $eventAndListenerTree);
        $methodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($eventVariable, $getterMethod);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($param->var, $methodCall);
    }
}
