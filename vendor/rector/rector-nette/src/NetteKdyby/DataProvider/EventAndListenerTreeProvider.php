<?php

declare (strict_types=1);
namespace Rector\NetteKdyby\DataProvider;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Return_;
use Rector\NetteKdyby\Naming\EventClassNaming;
use Rector\NetteKdyby\NodeFactory\DispatchMethodCallFactory;
use Rector\NetteKdyby\NodeFactory\EventValueObjectClassFactory;
use Rector\NetteKdyby\NodeResolver\ListeningMethodsCollector;
use Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use Rector\NetteKdyby\ValueObject\GetterMethodBlueprint;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
final class EventAndListenerTreeProvider
{
    /**
     * @var EventAndListenerTree[]
     */
    private $eventAndListenerTrees = [];
    /**
     * @var OnPropertyMagicCallProvider
     */
    private $onPropertyMagicCallProvider;
    /**
     * @var ListeningMethodsCollector
     */
    private $listeningMethodsCollector;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var EventClassNaming
     */
    private $eventClassNaming;
    /**
     * @var EventValueObjectClassFactory
     */
    private $eventValueObjectClassFactory;
    /**
     * @var DispatchMethodCallFactory
     */
    private $dispatchMethodCallFactory;
    /**
     * @var GetSubscribedEventsClassMethodProvider
     */
    private $getSubscribedEventsClassMethodProvider;
    public function __construct(\Rector\NetteKdyby\NodeFactory\DispatchMethodCallFactory $dispatchMethodCallFactory, \Rector\NetteKdyby\Naming\EventClassNaming $eventClassNaming, \Rector\NetteKdyby\NodeFactory\EventValueObjectClassFactory $eventValueObjectClassFactory, \Rector\NetteKdyby\DataProvider\GetSubscribedEventsClassMethodProvider $getSubscribedEventsClassMethodProvider, \Rector\NetteKdyby\NodeResolver\ListeningMethodsCollector $listeningMethodsCollector, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NetteKdyby\DataProvider\OnPropertyMagicCallProvider $onPropertyMagicCallProvider)
    {
        $this->onPropertyMagicCallProvider = $onPropertyMagicCallProvider;
        $this->listeningMethodsCollector = $listeningMethodsCollector;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->eventClassNaming = $eventClassNaming;
        $this->eventValueObjectClassFactory = $eventValueObjectClassFactory;
        $this->dispatchMethodCallFactory = $dispatchMethodCallFactory;
        $this->getSubscribedEventsClassMethodProvider = $getSubscribedEventsClassMethodProvider;
    }
    public function matchMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\Rector\NetteKdyby\ValueObject\EventAndListenerTree
    {
        $this->initializeEventAndListenerTrees();
        foreach ($this->eventAndListenerTrees as $eventAndListenerTree) {
            if ($eventAndListenerTree->getMagicDispatchMethodCall() !== $methodCall) {
                continue;
            }
            return $eventAndListenerTree;
        }
        return null;
    }
    /**
     * @return EventAndListenerTree[]
     */
    public function provide() : array
    {
        $this->initializeEventAndListenerTrees();
        return $this->eventAndListenerTrees;
    }
    private function initializeEventAndListenerTrees() : void
    {
        if ($this->eventAndListenerTrees !== [] && !\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return;
        }
        $this->eventAndListenerTrees = [];
        foreach ($this->onPropertyMagicCallProvider->provide() as $methodCall) {
            $magicProperty = $this->resolveMagicProperty($methodCall);
            $eventClassName = $this->eventClassNaming->createEventClassNameFromMethodCall($methodCall);
            $eventFileLocation = $this->eventClassNaming->resolveEventFileLocationFromMethodCall($methodCall);
            $eventClassInNamespace = $this->eventValueObjectClassFactory->create($eventClassName, $methodCall->args);
            $dispatchMethodCall = $this->dispatchMethodCallFactory->createFromEventClassName($eventClassName);
            // getter names by variable name and type
            $getterMethodsBlueprints = $this->resolveGetterMethodBlueprint($eventClassInNamespace);
            $eventAndListenerTree = new \Rector\NetteKdyby\ValueObject\EventAndListenerTree($methodCall, $magicProperty, $eventClassName, $eventFileLocation, $eventClassInNamespace, $dispatchMethodCall, $this->getListeningClassMethodsInEventSubscriberByClass($eventClassName), $getterMethodsBlueprints);
            $this->eventAndListenerTrees[] = $eventAndListenerTree;
        }
    }
    private function resolveMagicProperty(\PhpParser\Node\Expr\MethodCall $methodCall) : ?\PhpParser\Node\Stmt\Property
    {
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($methodCall->name);
        /** @var Class_ $classLike */
        $classLike = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        return $classLike->getProperty($methodName);
    }
    /**
     * @return array<class-string, ClassMethod[]>
     */
    private function getListeningClassMethodsInEventSubscriberByClass(string $eventClassName) : array
    {
        $listeningClassMethodsByClass = [];
        foreach ($this->getSubscribedEventsClassMethodProvider->provide() as $getSubscribedClassMethod) {
            /** @var class-string $className */
            $className = $getSubscribedClassMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            $listeningClassMethods = $this->listeningMethodsCollector->classMethodsListeningToEventClass($getSubscribedClassMethod, \Rector\NetteKdyby\NodeResolver\ListeningMethodsCollector::EVENT_TYPE_CUSTOM, $eventClassName);
            $listeningClassMethodsByClass[$className] = $listeningClassMethods;
        }
        return $listeningClassMethodsByClass;
    }
    /**
     * @return GetterMethodBlueprint[]
     */
    private function resolveGetterMethodBlueprint(\PhpParser\Node\Stmt\Namespace_ $eventClassInNamespace) : array
    {
        /** @var Class_ $eventClass */
        $eventClass = $eventClassInNamespace->stmts[0];
        $getterMethodBlueprints = [];
        foreach ($eventClass->getMethods() as $classMethod) {
            if (!$this->nodeNameResolver->isName($classMethod, 'get*')) {
                continue;
            }
            $stmts = (array) $classMethod->stmts;
            /** @var Return_ $return */
            $return = $stmts[0];
            /** @var PropertyFetch $propertyFetch */
            $propertyFetch = $return->expr;
            /** @var string $classMethodName */
            $classMethodName = $this->nodeNameResolver->getName($classMethod);
            /** @var string $variableName */
            $variableName = $this->nodeNameResolver->getName($propertyFetch->name);
            $getterMethodBlueprints[] = new \Rector\NetteKdyby\ValueObject\GetterMethodBlueprint($classMethodName, $classMethod->returnType, $variableName);
        }
        return $getterMethodBlueprints;
    }
}
