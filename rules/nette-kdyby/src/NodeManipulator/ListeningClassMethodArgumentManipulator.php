<?php

declare (strict_types=1);
namespace Rector\NetteKdyby\NodeManipulator;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\CodingStyle\Naming\ClassNaming;
use Rector\NetteKdyby\ContributeEventClassResolver;
use Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use Rector\NetteKdyby\ValueObject\EventClassAndClassMethod;
use RectorPrefix20210311\Symfony\Contracts\EventDispatcher\Event;
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
     * @var ParamAnalyzer
     */
    private $paramAnalyzer;
    public function __construct(\Rector\CodingStyle\Naming\ClassNaming $classNaming, \Rector\NetteKdyby\ContributeEventClassResolver $contributeEventClassResolver, \Rector\NetteKdyby\NodeManipulator\ParamAnalyzer $paramAnalyzer)
    {
        $this->classNaming = $classNaming;
        $this->contributeEventClassResolver = $contributeEventClassResolver;
        $this->paramAnalyzer = $paramAnalyzer;
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
        foreach ($classMethodsByEventClass as $classMethods) {
            // are attributes already replaced
            $classMethod = $classMethods->getClassMethod();
            $eventParameterReplaced = $classMethod->getAttribute(self::EVENT_PARAMETER_REPLACED);
            if ($eventParameterReplaced) {
                continue;
            }
            $oldParams = $classMethod->params;
            $eventClass = $eventAndListenerTree !== null ? $eventAndListenerTree->getEventClassName() : $classMethods->getEventClass();
            $this->changeClassParamToEventClass($eventClass, $classMethod);
            // move params to getter on event
            foreach ($oldParams as $oldParam) {
                if (!$this->paramAnalyzer->isParamUsedInClassMethod($classMethod, $oldParam)) {
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
    private function createEventGetterToVariableMethodCall(string $eventClass, \PhpParser\Node\Param $param, ?\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : \PhpParser\Node\Expr\Assign
    {
        $paramName = $this->classNaming->getVariableName($eventClass);
        $eventVariable = new \PhpParser\Node\Expr\Variable($paramName);
        $getterMethod = $this->contributeEventClassResolver->resolveGetterMethodByEventClassAndParam($eventClass, $param, $eventAndListenerTree);
        $methodCall = new \PhpParser\Node\Expr\MethodCall($eventVariable, $getterMethod);
        return new \PhpParser\Node\Expr\Assign($param->var, $methodCall);
    }
}
