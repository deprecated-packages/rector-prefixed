<?php

declare (strict_types=1);
namespace Rector\NetteKdyby\NodeResolver;

use _PhpScoperbf340cb0be9d\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\NetteKdyby\Naming\EventClassNaming;
use Rector\NetteKdyby\ValueObject\EventClassAndClassMethod;
use Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass;
use Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \Rector\NetteKdyby\Naming\EventClassNaming $eventClassNaming, \Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->valueResolver = $valueResolver;
        $this->eventClassNaming = $eventClassNaming;
    }
    /**
     * @return EventClassAndClassMethod[]
     */
    public function collectFromClassAndGetSubscribedEventClassMethod(\PhpParser\Node\Stmt\ClassMethod $getSubscribedEventsClassMethod, string $type) : array
    {
        /** @var Class_ $classLike */
        $classLike = $getSubscribedEventsClassMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        $this->eventClassesAndClassMethods = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $getSubscribedEventsClassMethod->stmts, function (\PhpParser\Node $node) use($classLike, $type) {
            $classMethod = $this->matchClassMethodByArrayItem($node, $classLike);
            if ($classMethod === null) {
                return null;
            }
            if (!$node instanceof \PhpParser\Node\Expr\ArrayItem) {
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
            if (!$node instanceof \PhpParser\Node\Expr\ArrayItem) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
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
    public function classMethodsListeningToEventClass(\PhpParser\Node\Stmt\ClassMethod $getSubscribedEventsClassMethod, string $type, string $eventClassName) : array
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
    private function matchClassMethodByArrayItem(\PhpParser\Node $node, \PhpParser\Node\Stmt\Class_ $class) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        if (!$node instanceof \PhpParser\Node\Expr\ArrayItem) {
            return null;
        }
        if ($node->key === null) {
            return null;
        }
        return $this->matchClassMethodByNodeValue($class, $node->value);
    }
    private function resolveContributeEventClassAndSubscribedClassMethod(string $eventClass, \PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $contributeEventClasses = \Rector\NetteKdyby\ValueObject\NetteEventToContributeEventClass::PROPERTY_TO_EVENT_CLASS;
        if (!\in_array($eventClass, $contributeEventClasses, \true)) {
            return;
        }
        $this->eventClassesAndClassMethods[] = new \Rector\NetteKdyby\ValueObject\EventClassAndClassMethod($eventClass, $classMethod);
    }
    private function resolveCustomClassMethodAndEventClass(\PhpParser\Node\Expr\ArrayItem $arrayItem, \PhpParser\Node\Stmt\Class_ $class, string $eventClass) : ?\Rector\NetteKdyby\ValueObject\EventClassAndClassMethod
    {
        // custom method name
        $classMethodName = $this->valueResolver->getValue($arrayItem->value);
        $classMethod = $class->getMethod($classMethodName);
        if (\_PhpScoperbf340cb0be9d\Nette\Utils\Strings::contains($eventClass, '::')) {
            [$dispatchingClass, $property] = \explode('::', $eventClass);
            $eventClass = $this->eventClassNaming->createEventClassNameFromClassAndProperty($dispatchingClass, $property);
        }
        if ($classMethod === null) {
            return null;
        }
        return new \Rector\NetteKdyby\ValueObject\EventClassAndClassMethod($eventClass, $classMethod);
    }
    private function matchClassMethodByNodeValue(\PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node\Expr $expr) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        $possibleMethodName = $this->valueResolver->getValue($expr);
        if (!\is_string($possibleMethodName)) {
            return null;
        }
        return $class->getMethod($possibleMethodName);
    }
}
