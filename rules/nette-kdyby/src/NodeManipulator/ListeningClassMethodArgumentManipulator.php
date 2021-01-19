<?php

declare (strict_types=1);
namespace Rector\NetteKdyby\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\CodingStyle\Naming\ClassNaming;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NetteKdyby\ContributeEventClassResolver;
use Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use Rector\NetteKdyby\ValueObject\EventClassAndClassMethod;
use RectorPrefix20210119\Symfony\Contracts\EventDispatcher\Event;
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
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\CodingStyle\Naming\ClassNaming $classNaming, \Rector\NetteKdyby\ContributeEventClassResolver $contributeEventClassResolver)
    {
        $this->classNaming = $classNaming;
        $this->contributeEventClassResolver = $contributeEventClassResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function changeFromEventAndListenerTreeAndCurrentClassName(\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree, string $className) : void
    {
        $listenerClassMethods = $eventAndListenerTree->getListenerClassMethodsByClass($className);
        if ($listenerClassMethods === []) {
            return;
        }
        $classMethodsByEventClass = [];
        foreach ($listenerClassMethods as $listenerClassMethod) {
            $classMethodsByEventClass[] = new \Rector\NetteKdyby\ValueObject\EventClassAndClassMethod($className, $listenerClassMethod);
        }
        $this->change($classMethodsByEventClass, $eventAndListenerTree);
    }
    /**
     * @param EventClassAndClassMethod[] $classMethodsByEventClass
     */
    public function change(array $classMethodsByEventClass, ?\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : void
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
                $expression = new \PhpParser\Node\Stmt\Expression($eventGetterToVariableAssign);
                $classMethod->stmts = \array_merge([$expression], (array) $classMethod->stmts);
            }
            $classMethod->setAttribute(self::EVENT_PARAMETER_REPLACED, \true);
        }
    }
    private function changeClassParamToEventClass(string $eventClass, \PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $paramName = $this->classNaming->getVariableName($eventClass);
        $eventVariable = new \PhpParser\Node\Expr\Variable($paramName);
        $param = new \PhpParser\Node\Param($eventVariable, null, new \PhpParser\Node\Name\FullyQualified($eventClass));
        $classMethod->params = [$param];
    }
    private function isParamUsedInClassMethodBody(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Param $param) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\PhpParser\Node $node) use($param) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $this->betterStandardPrinter->areNodesEqual($node, $param->var);
        });
    }
    private function createEventGetterToVariableMethodCall(string $eventClass, \PhpParser\Node\Param $param, ?\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : \PhpParser\Node\Expr\Assign
    {
        $paramName = $this->classNaming->getVariableName($eventClass);
        $eventVariable = new \PhpParser\Node\Expr\Variable($paramName);
        $getterMethod = $this->contributeEventClassResolver->resolveGetterMethodByEventClassAndParam($eventClass, $param, $eventAndListenerTree);
        $methodCall = new \PhpParser\Node\Expr\MethodCall($eventVariable, $getterMethod);
        return new \PhpParser\Node\Expr\Assign($param->var, $methodCall);
    }
}
