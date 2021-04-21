<?php

declare(strict_types=1);

namespace Rector\Nette\Kdyby\NodeResolver;

use Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\Nette\Kdyby\Naming\EventClassNaming;
use Rector\Nette\Kdyby\ValueObject\EventClassAndClassMethod;
use Rector\Nette\Kdyby\ValueObject\NetteEventToContributeEventClass;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;

final class ListeningMethodsCollector
{
    /**
     * @var string
     */
    const EVENT_TYPE_CONTRIBUTTE = 'contributte';

    /**
     * @var string
     */
    const EVENT_TYPE_CUSTOM = 'custom';

    /**
     * @var EventClassAndClassMethod[]
     */
    private $eventClassesAndClassMethods = [];

    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;

    /**
     * @var ValueResolver
     */
    private $valueResolver;

    /**
     * @var EventClassNaming
     */
    private $eventClassNaming;

    public function __construct(
        SimpleCallableNodeTraverser $simpleCallableNodeTraverser,
        EventClassNaming $eventClassNaming,
        ValueResolver $valueResolver
    ) {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->valueResolver = $valueResolver;
        $this->eventClassNaming = $eventClassNaming;
    }

    /**
     * @return EventClassAndClassMethod[]
     */
    public function collectFromClassAndGetSubscribedEventClassMethod(
        ClassMethod $getSubscribedEventsClassMethod,
        string $type
    ): array {
        /** @var Class_ $classLike */
        $classLike = $getSubscribedEventsClassMethod->getAttribute(AttributeKey::CLASS_NODE);

        $this->eventClassesAndClassMethods = [];

        $this->simpleCallableNodeTraverser->traverseNodesWithCallable(
            (array) $getSubscribedEventsClassMethod->stmts,
            function (Node $node) use ($classLike, $type) {
                $classMethod = $this->matchClassMethodByArrayItem($node, $classLike);
                if (! $classMethod instanceof ClassMethod) {
                    return null;
                }

                if (! $node instanceof ArrayItem) {
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

                if (! $node instanceof ArrayItem) {
                    throw new ShouldNotHappenException();
                }

                $eventClassAndClassMethod = $this->resolveCustomClassMethodAndEventClass(
                    $node,
                    $classLike,
                    $eventClass
                );

                if (! $eventClassAndClassMethod instanceof EventClassAndClassMethod) {
                    return null;
                }

                $this->eventClassesAndClassMethods[] = $eventClassAndClassMethod;
                return null;
            }
        );

        return $this->eventClassesAndClassMethods;
    }

    /**
     * @return ClassMethod[]
     */
    public function classMethodsListeningToEventClass(
        ClassMethod $getSubscribedEventsClassMethod,
        string $type,
        string $eventClassName
    ): array {
        $eventClassesAndClassMethods = $this->collectFromClassAndGetSubscribedEventClassMethod(
            $getSubscribedEventsClassMethod,
            $type
        );

        $classMethods = [];
        foreach ($eventClassesAndClassMethods as $eventClassAndClassMethod) {
            if ($eventClassAndClassMethod->getEventClass() !== $eventClassName) {
                continue;
            }

            $classMethods[] = $eventClassAndClassMethod->getClassMethod();
        }

        return $classMethods;
    }

    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    private function matchClassMethodByArrayItem(Node $node, Class_ $class)
    {
        if (! $node instanceof ArrayItem) {
            return null;
        }

        if ($node->key === null) {
            return null;
        }

        return $this->matchClassMethodByNodeValue($class, $node->value);
    }

    /**
     * @return void
     */
    private function resolveContributeEventClassAndSubscribedClassMethod(
        string $eventClass,
        ClassMethod $classMethod
    ) {
        $contributeEventClasses = NetteEventToContributeEventClass::PROPERTY_TO_EVENT_CLASS;

        if (! in_array($eventClass, $contributeEventClasses, true)) {
            return;
        }

        $this->eventClassesAndClassMethods[] = new EventClassAndClassMethod($eventClass, $classMethod);
    }

    /**
     * @return \Rector\Nette\Kdyby\ValueObject\EventClassAndClassMethod|null
     */
    private function resolveCustomClassMethodAndEventClass(
        ArrayItem $arrayItem,
        Class_ $class,
        string $eventClass
    ) {
        // custom method name
        $classMethodName = $this->valueResolver->getValue($arrayItem->value);
        $classMethod = $class->getMethod($classMethodName);

        if (Strings::contains($eventClass, '::')) {
            list($dispatchingClass, $property) = explode('::', $eventClass);
            $eventClass = $this->eventClassNaming->createEventClassNameFromClassAndProperty(
                $dispatchingClass,
                $property
            );
        }

        if (! $classMethod instanceof ClassMethod) {
            return null;
        }

        return new EventClassAndClassMethod($eventClass, $classMethod);
    }

    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    private function matchClassMethodByNodeValue(Class_ $class, Expr $expr)
    {
        $possibleMethodName = $this->valueResolver->getValue($expr);
        if (! is_string($possibleMethodName)) {
            return null;
        }

        return $class->getMethod($possibleMethodName);
    }
}
