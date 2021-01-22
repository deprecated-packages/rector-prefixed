<?php

declare (strict_types=1);
namespace Rector\Privatization\NodeAnalyzer;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Type\TypeWithClassName;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeCollector\ValueObject\ArrayCallable;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use ReflectionMethod;
final class ClassMethodExternalCallNodeAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var EventSubscriberMethodNamesResolver
     */
    private $eventSubscriberMethodNamesResolver;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\Rector\Privatization\NodeAnalyzer\EventSubscriberMethodNamesResolver $eventSubscriberMethodNamesResolver, \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->eventSubscriberMethodNamesResolver = $eventSubscriberMethodNamesResolver;
        $this->nodeRepository = $nodeRepository;
    }
    public function hasExternalCall(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $methodCalls = $this->nodeRepository->findCallsByClassMethod($classMethod);
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        if ($this->isArrayCallable($classMethod, $methodCalls, $methodName)) {
            return \true;
        }
        if ($this->isEventSubscriberMethod($classMethod, $methodName)) {
            return \true;
        }
        // remove static calls and [$this, 'call']
        /** @var MethodCall[] $methodCalls */
        $methodCalls = \array_filter($methodCalls, function (object $node) : bool {
            return $node instanceof \PhpParser\Node\Expr\MethodCall;
        });
        foreach ($methodCalls as $methodCall) {
            $callerType = $this->nodeTypeResolver->resolve($methodCall->var);
            if (!$callerType instanceof \PHPStan\Type\TypeWithClassName) {
                // unable to handle reliably
                return \true;
            }
            // external call
            $nodeClassName = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($nodeClassName !== $callerType->getClassName()) {
                return \true;
            }
            /** @var string $methodName */
            $methodName = $this->nodeNameResolver->getName($classMethod);
            $reflectionMethod = new \ReflectionMethod($nodeClassName, $methodName);
            // parent class name, must be at least protected
            $reflectionClass = $reflectionMethod->getDeclaringClass();
            if ($reflectionClass->getName() !== $nodeClassName) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param StaticCall[]|MethodCall[]|ArrayCallable[] $methodCalls
     */
    private function isArrayCallable(\PhpParser\Node\Stmt\ClassMethod $classMethod, array $methodCalls, string $methodName) : bool
    {
        /** @var ArrayCallable[] $arrayCallables */
        $arrayCallables = \array_filter($methodCalls, function (object $node) : bool {
            return $node instanceof \Rector\NodeCollector\ValueObject\ArrayCallable;
        });
        $className = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($arrayCallables as $arrayCallable) {
            if ($className === $arrayCallable->getClass() && $methodName === $arrayCallable->getMethod()) {
                return \true;
            }
        }
        return \false;
    }
    private function isEventSubscriberMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $methodName) : bool
    {
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        if (!$this->nodeTypeResolver->isObjectType($classLike, 'Symfony\\Component\\EventDispatcher\\EventSubscriberInterface')) {
            return \false;
        }
        $getSubscribedEventsClassMethod = $classLike->getMethod('getSubscribedEvents');
        if (!$getSubscribedEventsClassMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        $methodNames = $this->eventSubscriberMethodNamesResolver->resolveFromClassMethod($getSubscribedEventsClassMethod);
        return \in_array($methodName, $methodNames, \true);
    }
}
