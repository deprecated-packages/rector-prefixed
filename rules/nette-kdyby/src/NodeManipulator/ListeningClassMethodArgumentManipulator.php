<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\NodeManipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\NetteKdyby\ContributeEventClassResolver;
use _PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use _PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject\EventClassAndClassMethod;
use _PhpScoperb75b35f52b74\Symfony\Contracts\EventDispatcher\Event;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoperb75b35f52b74\Rector\NetteKdyby\ContributeEventClassResolver $contributeEventClassResolver)
    {
        $this->classNaming = $classNaming;
        $this->contributeEventClassResolver = $contributeEventClassResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function changeFromEventAndListenerTreeAndCurrentClassName(\_PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree, string $className) : void
    {
        $listenerClassMethods = $eventAndListenerTree->getListenerClassMethodsByClass($className);
        if ($listenerClassMethods === []) {
            return;
        }
        $classMethodsByEventClass = [];
        foreach ($listenerClassMethods as $listenerClassMethod) {
            $classMethodsByEventClass[] = new \_PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject\EventClassAndClassMethod($className, $listenerClassMethod);
        }
        $this->change($classMethodsByEventClass, $eventAndListenerTree);
    }
    /**
     * @param EventClassAndClassMethod[] $classMethodsByEventClass
     */
    public function change(array $classMethodsByEventClass, ?\_PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : void
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
                $expression = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($eventGetterToVariableAssign);
                $classMethod->stmts = \array_merge([$expression], (array) $classMethod->stmts);
            }
            $classMethod->setAttribute(self::EVENT_PARAMETER_REPLACED, \true);
        }
    }
    private function changeClassParamToEventClass(string $eventClass, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $paramName = $this->classNaming->getVariableName($eventClass);
        $eventVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($paramName);
        $param = new \_PhpScoperb75b35f52b74\PhpParser\Node\Param($eventVariable, null, new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($eventClass));
        $classMethod->params = [$param];
    }
    private function isParamUsedInClassMethodBody(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($param) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->betterStandardPrinter->areNodesEqual($node, $param->var);
        });
    }
    private function createEventGetterToVariableMethodCall(string $eventClass, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, ?\_PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        $paramName = $this->classNaming->getVariableName($eventClass);
        $eventVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($paramName);
        $getterMethod = $this->contributeEventClassResolver->resolveGetterMethodByEventClassAndParam($eventClass, $param, $eventAndListenerTree);
        $methodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($eventVariable, $getterMethod);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($param->var, $methodCall);
    }
}
