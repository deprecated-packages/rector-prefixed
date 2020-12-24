<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteKdyby\NodeResolver;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\EventClassNaming;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\ValueObject\EventClassAndClassMethod;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class ListeningMethodsCollector
{
    /**
     * @var string
     */
    public const EVENT_TYPE_CONTRIBUTTE = 'contributte';
    /**
     * @var string
     */
    public const EVENT_TYPE_CUSTOM = 'custom';
    /**
     * @var EventClassAndClassMethod[]
     */
    private $eventClassesAndClassMethods = [];
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var EventClassNaming
     */
    private $eventClassNaming;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\EventClassNaming $eventClassNaming, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->valueResolver = $valueResolver;
        $this->eventClassNaming = $eventClassNaming;
    }
    /**
     * @return EventClassAndClassMethod[]
     */
    public function collectFromClassAndGetSubscribedEventClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $getSubscribedEventsClassMethod, string $type) : array
    {
        /** @var Class_ $classLike */
        $classLike = $getSubscribedEventsClassMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        $this->eventClassesAndClassMethods = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $getSubscribedEventsClassMethod->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($classLike, $type) {
            $classMethod = $this->matchClassMethodByArrayItem($node, $classLike);
            if ($classMethod === null) {
                return null;
            }
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
                return;
            }
            if ($node->key === null) {
                return;
            }
            $eventClass = $this->valueResolver->getValue($node->key);
            if ($type === self::EVENT_TYPE_CONTRIBUTTE) {
                /** @var string $eventClass */
                $this->resolveContributeEventClassAndSubscribedClassMethod($eventClass, $classMethod);
                return null;
            }
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
            }
            $eventClassAndClassMethod = $this->resolveCustomClassMethodAndEventClass($node, $classLike, $eventClass);
            if ($eventClassAndClassMethod === null) {
                return null;
            }
            $this->eventClassesAndClassMethods[] = $eventClassAndClassMethod;
            return null;
        });
        return $this->eventClassesAndClassMethods;
    }
    /**
     * @return ClassMethod[]
     */
    public function classMethodsListeningToEventClass(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $getSubscribedEventsClassMethod, string $type, string $eventClassName) : array
    {
        $eventClassesAndClassMethods = $this->collectFromClassAndGetSubscribedEventClassMethod($getSubscribedEventsClassMethod, $type);
        $classMethods = [];
        foreach ($eventClassesAndClassMethods as $eventClassAndClassMethod) {
            if ($eventClassAndClassMethod->getEventClass() !== $eventClassName) {
                continue;
            }
            $classMethods[] = $eventClassAndClassMethod->getClassMethod();
        }
        return $classMethods;
    }
    private function matchClassMethodByArrayItem(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
            return null;
        }
        if ($node->key === null) {
            return null;
        }
        return $this->matchClassMethodByNodeValue($class, $node->value);
    }
    private function resolveContributeEventClassAndSubscribedClassMethod(string $eventClass, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $contributeEventClasses = \_PhpScoper0a6b37af0871\Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass::PROPERTY_TO_EVENT_CLASS;
        if (!\in_array($eventClass, $contributeEventClasses, \true)) {
            return;
        }
        $this->eventClassesAndClassMethods[] = new \_PhpScoper0a6b37af0871\Rector\NetteKdyby\ValueObject\EventClassAndClassMethod($eventClass, $classMethod);
    }
    private function resolveCustomClassMethodAndEventClass(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem $arrayItem, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, string $eventClass) : ?\_PhpScoper0a6b37af0871\Rector\NetteKdyby\ValueObject\EventClassAndClassMethod
    {
        // custom method name
        $classMethodName = $this->valueResolver->getValue($arrayItem->value);
        $classMethod = $class->getMethod($classMethodName);
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($eventClass, '::')) {
            [$dispatchingClass, $property] = \explode('::', $eventClass);
            $eventClass = $this->eventClassNaming->createEventClassNameFromClassAndProperty($dispatchingClass, $property);
        }
        if ($classMethod === null) {
            return null;
        }
        return new \_PhpScoper0a6b37af0871\Rector\NetteKdyby\ValueObject\EventClassAndClassMethod($eventClass, $classMethod);
    }
    private function matchClassMethodByNodeValue(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $possibleMethodName = $this->valueResolver->getValue($expr);
        if (!\is_string($possibleMethodName)) {
            return null;
        }
        return $class->getMethod($possibleMethodName);
    }
}
