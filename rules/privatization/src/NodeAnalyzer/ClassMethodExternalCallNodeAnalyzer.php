<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Privatization\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\ValueObject\ArrayCallable;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Privatization\NodeAnalyzer\EventSubscriberMethodNamesResolver $eventSubscriberMethodNamesResolver, \_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->eventSubscriberMethodNamesResolver = $eventSubscriberMethodNamesResolver;
        $this->nodeRepository = $nodeRepository;
    }
    public function hasExternalCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
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
            return $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
        });
        foreach ($methodCalls as $methodCall) {
            $callerType = $this->nodeTypeResolver->resolve($methodCall->var);
            if (!$callerType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
                // unable to handle reliably
                return \true;
            }
            // external call
            $nodeClassName = $methodCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
    private function isArrayCallable(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, array $methodCalls, string $methodName) : bool
    {
        /** @var ArrayCallable[] $arrayCallables */
        $arrayCallables = \array_filter($methodCalls, function (object $node) : bool {
            return $node instanceof \_PhpScoper0a6b37af0871\Rector\NodeCollector\ValueObject\ArrayCallable;
        });
        foreach ($arrayCallables as $arrayCallable) {
            $className = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($className === $arrayCallable->getClass() && $methodName === $arrayCallable->getMethod()) {
                return \true;
            }
        }
        return \false;
    }
    private function isEventSubscriberMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, string $methodName) : bool
    {
        $classLike = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        if (!$this->nodeTypeResolver->isObjectType($classLike, '_PhpScoper0a6b37af0871\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface')) {
            return \false;
        }
        $getSubscribedEventsClassMethod = $classLike->getMethod('getSubscribedEvents');
        if ($getSubscribedEventsClassMethod === null) {
            return \false;
        }
        $methodNames = $this->eventSubscriberMethodNamesResolver->resolveFromClassMethod($getSubscribedEventsClassMethod);
        return \in_array($methodName, $methodNames, \true);
    }
}
