<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
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
     * @var ClassMethod[][]
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
     * @param ClassMethod[][] $listenerMethodsByEventSubscriberClass
     * @param GetterMethodBlueprint[] $getterMethodsBlueprints
     */
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $magicDispatchMethodCall, ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $onMagicProperty, string $eventClassName, string $eventFileLocation, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_ $eventClassInNamespace, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $eventDispatcherDispatchMethodCall, array $listenerMethodsByEventSubscriberClass, array $getterMethodsBlueprints)
    {
        $this->magicDispatchMethodCall = $magicDispatchMethodCall;
        $this->onMagicProperty = $onMagicProperty;
        $this->eventClassName = $eventClassName;
        $this->eventFileLocation = $eventFileLocation;
        $this->eventClassInNamespace = $eventClassInNamespace;
        $this->listenerMethodsByEventSubscriberClass = $listenerMethodsByEventSubscriberClass;
        $this->eventDispatcherDispatchMethodCall = $eventDispatcherDispatchMethodCall;
        $this->getterMethodBlueprints = $getterMethodsBlueprints;
    }
    public function getEventClassName() : string
    {
        return $this->eventClassName;
    }
    /**
     * @return ClassMethod[]
     */
    public function getListenerClassMethodsByClass(string $className) : array
    {
        return $this->listenerMethodsByEventSubscriberClass[$className] ?? [];
    }
    public function getOnMagicProperty() : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        return $this->onMagicProperty;
    }
    public function getEventFileLocation() : string
    {
        return $this->eventFileLocation;
    }
    public function getMagicDispatchMethodCall() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        return $this->magicDispatchMethodCall;
    }
    public function getEventClassInNamespace() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_
    {
        return $this->eventClassInNamespace;
    }
    public function getEventDispatcherDispatchMethodCall() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        return $this->eventDispatcherDispatchMethodCall;
    }
    /**
     * @return GetterMethodBlueprint[]
     */
    public function getGetterMethodBlueprints() : array
    {
        return $this->getterMethodBlueprints;
    }
}
