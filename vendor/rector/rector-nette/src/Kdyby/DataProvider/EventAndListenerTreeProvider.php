<?php

declare(strict_types=1);

namespace Rector\Nette\Kdyby\DataProvider;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Return_;
use Rector\Nette\Kdyby\Naming\EventClassNaming;
use Rector\Nette\Kdyby\NodeFactory\DispatchMethodCallFactory;
use Rector\Nette\Kdyby\NodeFactory\EventValueObjectClassFactory;
use Rector\Nette\Kdyby\NodeResolver\ListeningMethodsCollector;
use Rector\Nette\Kdyby\ValueObject\EventAndListenerTree;
use Rector\Nette\Kdyby\ValueObject\GetterMethodBlueprint;
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

    public function __construct(
        DispatchMethodCallFactory $dispatchMethodCallFactory,
        EventClassNaming $eventClassNaming,
        EventValueObjectClassFactory $eventValueObjectClassFactory,
        GetSubscribedEventsClassMethodProvider $getSubscribedEventsClassMethodProvider,
        ListeningMethodsCollector $listeningMethodsCollector,
        NodeNameResolver $nodeNameResolver,
        OnPropertyMagicCallProvider $onPropertyMagicCallProvider
    ) {
        $this->onPropertyMagicCallProvider = $onPropertyMagicCallProvider;
        $this->listeningMethodsCollector = $listeningMethodsCollector;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->eventClassNaming = $eventClassNaming;
        $this->eventValueObjectClassFactory = $eventValueObjectClassFactory;
        $this->dispatchMethodCallFactory = $dispatchMethodCallFactory;
        $this->getSubscribedEventsClassMethodProvider = $getSubscribedEventsClassMethodProvider;
    }

    /**
     * @return \Rector\Nette\Kdyby\ValueObject\EventAndListenerTree|null
     */
    public function matchMethodCall(MethodCall $methodCall)
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
    public function provide(): array
    {
        $this->initializeEventAndListenerTrees();

        return $this->eventAndListenerTrees;
    }

    /**
     * @return void
     */
    private function initializeEventAndListenerTrees()
    {
        if ($this->eventAndListenerTrees !== [] && ! StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return;
        }

        $this->eventAndListenerTrees = [];

        foreach ($this->onPropertyMagicCallProvider->provide() as $methodCall) {
            $magicProperty = $this->resolveMagicProperty($methodCall);

            $eventClassName = $this->eventClassNaming->createEventClassNameFromMethodCall($methodCall);

            $eventFileLocation = $this->eventClassNaming->resolveEventFileLocationFromMethodCall($methodCall);

            $eventClassInNamespace = $this->eventValueObjectClassFactory->create(
                $eventClassName,
                $methodCall->args
            );

            $dispatchMethodCall = $this->dispatchMethodCallFactory->createFromEventClassName($eventClassName);

            // getter names by variable name and type
            $getterMethodsBlueprints = $this->resolveGetterMethodBlueprint($eventClassInNamespace);

            $eventAndListenerTree = new EventAndListenerTree(
                $methodCall,
                $magicProperty,
                $eventClassName,
                $eventFileLocation,
                $eventClassInNamespace,
                $dispatchMethodCall,
                $this->getListeningClassMethodsInEventSubscriberByClass($eventClassName),
                $getterMethodsBlueprints
            );

            $this->eventAndListenerTrees[] = $eventAndListenerTree;
        }
    }

    /**
     * @return \PhpParser\Node\Stmt\Property|null
     */
    private function resolveMagicProperty(MethodCall $methodCall)
    {
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($methodCall->name);

        /** @var Class_ $classLike */
        $classLike = $methodCall->getAttribute(AttributeKey::CLASS_NODE);

        return $classLike->getProperty($methodName);
    }

    /**
     * @return array<class-string, ClassMethod[]>
     */
    private function getListeningClassMethodsInEventSubscriberByClass(string $eventClassName): array
    {
        $listeningClassMethodsByClass = [];

        foreach ($this->getSubscribedEventsClassMethodProvider->provide() as $getSubscribedClassMethod) {
            /** @var class-string $className */
            $className = $getSubscribedClassMethod->getAttribute(AttributeKey::CLASS_NAME);

            $listeningClassMethods = $this->listeningMethodsCollector->classMethodsListeningToEventClass(
                $getSubscribedClassMethod,
                ListeningMethodsCollector::EVENT_TYPE_CUSTOM,
                $eventClassName
            );

            $listeningClassMethodsByClass[$className] = $listeningClassMethods;
        }

        return $listeningClassMethodsByClass;
    }

    /**
     * @return GetterMethodBlueprint[]
     */
    private function resolveGetterMethodBlueprint(Namespace_ $eventClassInNamespace): array
    {
        /** @var Class_ $eventClass */
        $eventClass = $eventClassInNamespace->stmts[0];
        $getterMethodBlueprints = [];

        foreach ($eventClass->getMethods() as $classMethod) {
            if (! $this->nodeNameResolver->isName($classMethod, 'get*')) {
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

            $getterMethodBlueprints[] = new GetterMethodBlueprint(
                $classMethodName,
                $classMethod->returnType,
                $variableName
            );
        }

        return $getterMethodBlueprints;
    }
}
