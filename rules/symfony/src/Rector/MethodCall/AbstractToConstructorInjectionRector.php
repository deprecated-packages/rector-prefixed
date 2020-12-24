<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Symfony\ServiceMapProvider;
abstract class AbstractToConstructorInjectionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
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
    public function autowireAbstractToConstructorInjectionRector(\_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScopere8e811afab72\Rector\Symfony\ServiceMapProvider $applicationServiceMapProvider) : void
    {
        $this->propertyNaming = $propertyNaming;
        $this->applicationServiceMapProvider = $applicationServiceMapProvider;
    }
    protected function processMethodCallNode(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $serviceType = $this->getServiceTypeFromMethodCallArgument($methodCall);
        if (!$serviceType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return null;
        }
        $propertyName = $this->propertyNaming->fqnToVariableName($serviceType);
        $classLike = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->addConstructorDependencyToClass($classLike, $serviceType, $propertyName);
        return $this->createPropertyFetch('this', $propertyName);
    }
    private function getServiceTypeFromMethodCallArgument(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!isset($methodCall->args[0])) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $argument = $methodCall->args[0]->value;
        $serviceMap = $this->applicationServiceMapProvider->provide();
        if ($argument instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return $serviceMap->getServiceType($argument->value);
        }
        if ($argument instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch && $argument->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            $className = $this->getName($argument->class);
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($className);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
}
