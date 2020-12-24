<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\Symfony\ServiceMapProvider;
abstract class AbstractToConstructorInjectionRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyNaming
     */
    protected $propertyNaming;
    /**
     * @var ServiceMapProvider
     */
    private $applicationServiceMapProvider;
    /**
     * @required
     */
    public function autowireAbstractToConstructorInjectionRector(\_PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoper0a6b37af0871\Rector\Symfony\ServiceMapProvider $applicationServiceMapProvider) : void
    {
        $this->propertyNaming = $propertyNaming;
        $this->applicationServiceMapProvider = $applicationServiceMapProvider;
    }
    protected function processMethodCallNode(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $serviceType = $this->getServiceTypeFromMethodCallArgument($methodCall);
        if (!$serviceType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
            return null;
        }
        $propertyName = $this->propertyNaming->fqnToVariableName($serviceType);
        $classLike = $methodCall->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->addConstructorDependencyToClass($classLike, $serviceType, $propertyName);
        return $this->createPropertyFetch('this', $propertyName);
    }
    private function getServiceTypeFromMethodCallArgument(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (!isset($methodCall->args[0])) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $argument = $methodCall->args[0]->value;
        $serviceMap = $this->applicationServiceMapProvider->provide();
        if ($argument instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            return $serviceMap->getServiceType($argument->value);
        }
        if ($argument instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch && $argument->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            $className = $this->getName($argument->class);
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($className);
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
    }
}
