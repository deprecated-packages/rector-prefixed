<?php

declare(strict_types=1);

namespace Rector\Nette\Kdyby\ValueObject;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Property;

final class EventAndListenerTree
{
    /**
     * @var string
     */
    private $eventClassName;

    /**
     * @var string
     */
    private $eventFileLocation;

    /**
     * @var array<class-string, ClassMethod[]>
     */
    private $listenerMethodsByEventSubscriberClass = [];

    /**
     * @var GetterMethodBlueprint[]
     */
    private $getterMethodBlueprints = [];

    /**
     * @var MethodCall
     */
    private $magicDispatchMethodCall;

    /**
     * @var Namespace_
     */
    private $eventClassInNamespace;

    /**
     * @var MethodCall
     */
    private $eventDispatcherDispatchMethodCall;

    /**
     * @var Property|null
     */
    private $onMagicProperty;

    /**
     * @param array<class-string, ClassMethod[]> $listenerMethodsByEventSubscriberClass
     * @param GetterMethodBlueprint[] $getterMethodsBlueprints
     * @param \PhpParser\Node\Stmt\Property|null $onMagicProperty
     */
    public function __construct(
        MethodCall $magicDispatchMethodCall,
        $onMagicProperty,
        string $eventClassName,
        string $eventFileLocation,
        Namespace_ $eventClassInNamespace,
        MethodCall $eventDispatcherDispatchMethodCall,
        array $listenerMethodsByEventSubscriberClass,
        array $getterMethodsBlueprints
    ) {
        $this->magicDispatchMethodCall = $magicDispatchMethodCall;
        $this->onMagicProperty = $onMagicProperty;
        $this->eventClassName = $eventClassName;
        $this->eventFileLocation = $eventFileLocation;
        $this->eventClassInNamespace = $eventClassInNamespace;
        $this->listenerMethodsByEventSubscriberClass = $listenerMethodsByEventSubscriberClass;
        $this->eventDispatcherDispatchMethodCall = $eventDispatcherDispatchMethodCall;
        $this->getterMethodBlueprints = $getterMethodsBlueprints;
    }

    public function getEventClassName(): string
    {
        return $this->eventClassName;
    }

    /**
     * @return ClassMethod[]
     */
    public function getListenerClassMethodsByClass(string $className): array
    {
        return $this->listenerMethodsByEventSubscriberClass[$className] ?? [];
    }

    /**
     * @return \PhpParser\Node\Stmt\Property|null
     */
    public function getOnMagicProperty()
    {
        return $this->onMagicProperty;
    }

    public function getEventFileLocation(): string
    {
        return $this->eventFileLocation;
    }

    public function getMagicDispatchMethodCall(): MethodCall
    {
        return $this->magicDispatchMethodCall;
    }

    public function getEventClassInNamespace(): Namespace_
    {
        return $this->eventClassInNamespace;
    }

    public function getEventDispatcherDispatchMethodCall(): MethodCall
    {
        return $this->eventDispatcherDispatchMethodCall;
    }

    /**
     * @return GetterMethodBlueprint[]
     */
    public function getGetterMethodBlueprints(): array
    {
        return $this->getterMethodBlueprints;
    }
}
