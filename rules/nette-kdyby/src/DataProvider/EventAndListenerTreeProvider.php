<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteKdyby\DataProvider;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\Naming\EventClassNaming;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeFactory\DispatchMethodCallFactory;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeFactory\EventValueObjectClassFactory;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeResolver\ListeningMethodsCollector;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\ValueObject\GetterMethodBlueprint;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeFactory\DispatchMethodCallFactory $dispatchMethodCallFactory, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\Naming\EventClassNaming $eventClassNaming, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeFactory\EventValueObjectClassFactory $eventValueObjectClassFactory, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\DataProvider\GetSubscribedEventsClassMethodProvider $getSubscribedEventsClassMethodProvider, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeResolver\ListeningMethodsCollector $listeningMethodsCollector, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\DataProvider\OnPropertyMagicCallProvider $onPropertyMagicCallProvider)
    {
        $this->onPropertyMagicCallProvider = $onPropertyMagicCallProvider;
        $this->listeningMethodsCollector = $listeningMethodsCollector;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->eventClassNaming = $eventClassNaming;
        $this->eventValueObjectClassFactory = $eventValueObjectClassFactory;
        $this->dispatchMethodCallFactory = $dispatchMethodCallFactory;
        $this->getSubscribedEventsClassMethodProvider = $getSubscribedEventsClassMethodProvider;
    }
    public function matchMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a2ac50786fa\Rector\NetteKdyby\ValueObject\EventAndListenerTree
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
        if ($this->eventAndListenerTrees !== [] && !\_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return;
        }
        $this->eventAndListenerTrees = [];
        foreach ($this->onPropertyMagicCallProvider->provide() as $methodCall) {
            $magicProperty = $this->resolveMagicProperty($methodCall);
            $eventClassName = $this->eventClassNaming->createEventClassNameFromMethodCall($methodCall);
            $eventFileLocation = $this->eventClassNaming->resolveEventFileLocationFromMethodCall($methodCall);
            $eventClassInNamespace = $this->eventValueObjectClassFactory->create($eventClassName, (array) $methodCall->args);
            $dispatchMethodCall = $this->dispatchMethodCallFactory->createFromEventClassName($eventClassName);
            $listeningClassMethodsByClass = $this->getListeningClassMethodsInEventSubscriberByClass($eventClassName);
            // getter names by variable name and type
            $getterMethodsBlueprints = $this->resolveGetterMethodBlueprint($eventClassInNamespace);
            $eventAndListenerTree = new \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\ValueObject\EventAndListenerTree($methodCall, $magicProperty, $eventClassName, $eventFileLocation, $eventClassInNamespace, $dispatchMethodCall, $listeningClassMethodsByClass, $getterMethodsBlueprints);
            $this->eventAndListenerTrees[] = $eventAndListenerTree;
        }
    }
    private function resolveMagicProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property
    {
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($methodCall->name);
        /** @var Class_ $classLike */
        $classLike = $methodCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        return $classLike->getProperty($methodName);
    }
    /**
     * @return ClassMethod[][]
     */
    private function getListeningClassMethodsInEventSubscriberByClass(string $eventClassName) : array
    {
        $listeningClassMethodsByClass = [];
        foreach ($this->getSubscribedEventsClassMethodProvider->provide() as $getSubscribedClassMethod) {
            /** @var string $className */
            $className = $getSubscribedClassMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            $listeningClassMethods = $this->listeningMethodsCollector->classMethodsListeningToEventClass($getSubscribedClassMethod, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\NodeResolver\ListeningMethodsCollector::EVENT_TYPE_CUSTOM, $eventClassName);
            $listeningClassMethodsByClass[$className] = $listeningClassMethods;
        }
        return $listeningClassMethodsByClass;
    }
    /**
     * @return GetterMethodBlueprint[]
     */
    private function resolveGetterMethodBlueprint(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_ $eventClassInNamespace) : array
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
            $classMethodName = $this->nodeNameResolver->getName($classMethod);
            /** @var string $variableName */
            $variableName = $this->nodeNameResolver->getName($propertyFetch->name);
            $getterMethodBlueprints[] = new \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\ValueObject\GetterMethodBlueprint($classMethodName, $classMethod->returnType, $variableName);
        }
        return $getterMethodBlueprints;
    }
}
