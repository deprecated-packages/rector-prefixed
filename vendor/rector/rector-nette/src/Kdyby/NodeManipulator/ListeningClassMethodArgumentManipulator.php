<?php

declare(strict_types=1);

namespace Rector\Nette\Kdyby\NodeManipulator;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\CodingStyle\Naming\ClassNaming;
use Rector\Core\NodeAnalyzer\ParamAnalyzer;
use Rector\Nette\Kdyby\ContributeEventClassResolver;
use Rector\Nette\Kdyby\ValueObject\EventAndListenerTree;
use Rector\Nette\Kdyby\ValueObject\EventClassAndClassMethod;

final class ListeningClassMethodArgumentManipulator
{
    /**
     * @var string
     */
    const EVENT_PARAMETER_REPLACED = 'event_parameter_replaced';

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

    public function __construct(
        ClassNaming $classNaming,
        ContributeEventClassResolver $contributeEventClassResolver,
        ParamAnalyzer $paramAnalyzer
    ) {
        $this->classNaming = $classNaming;
        $this->contributeEventClassResolver = $contributeEventClassResolver;
        $this->paramAnalyzer = $paramAnalyzer;
    }

    /**
     * @return void
     */
    public function changeFromEventAndListenerTreeAndCurrentClassName(
        EventAndListenerTree $eventAndListenerTree,
        string $className
    ) {
        $listenerClassMethods = $eventAndListenerTree->getListenerClassMethodsByClass($className);
        if ($listenerClassMethods === []) {
            return;
        }

        $classMethodsByEventClass = [];
        foreach ($listenerClassMethods as $listenerClassMethod) {
            $classMethodsByEventClass[] = new EventClassAndClassMethod($className, $listenerClassMethod);
        }

        $this->change($classMethodsByEventClass, $eventAndListenerTree);
    }

    /**
     * @param EventClassAndClassMethod[] $classMethodsByEventClass
     * @param \Rector\Nette\Kdyby\ValueObject\EventAndListenerTree|null $eventAndListenerTree
     * @return void
     */
    public function change(array $classMethodsByEventClass, $eventAndListenerTree = null)
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
                if (! $this->paramAnalyzer->isParamUsedInClassMethod($classMethod, $oldParam)) {
                    continue;
                }

                $eventGetterToVariableAssign = $this->createEventGetterToVariableMethodCall(
                    $eventClass,
                    $oldParam,
                    $eventAndListenerTree
                );

                $expression = new Expression($eventGetterToVariableAssign);

                $classMethod->stmts = array_merge([$expression], (array) $classMethod->stmts);
            }

            $classMethod->setAttribute(self::EVENT_PARAMETER_REPLACED, true);
        }
    }

    /**
     * @return void
     */
    private function changeClassParamToEventClass(string $eventClass, ClassMethod $classMethod)
    {
        $paramName = $this->classNaming->getVariableName($eventClass);
        $eventVariable = new Variable($paramName);

        $param = new Param($eventVariable, null, new FullyQualified($eventClass));
        $classMethod->params = [$param];
    }

    /**
     * @param \Rector\Nette\Kdyby\ValueObject\EventAndListenerTree|null $eventAndListenerTree
     */
    private function createEventGetterToVariableMethodCall(
        string $eventClass,
        Param $param,
        $eventAndListenerTree
    ): Assign {
        $paramName = $this->classNaming->getVariableName($eventClass);
        $eventVariable = new Variable($paramName);

        $getterMethod = $this->contributeEventClassResolver->resolveGetterMethodByEventClassAndParam(
            $eventClass,
            $param,
            $eventAndListenerTree
        );

        $methodCall = new MethodCall($eventVariable, $getterMethod);

        return new Assign($param->var, $methodCall);
    }
}
