<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\Symfony\ServiceMapProvider;
abstract class AbstractToConstructorInjectionRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
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
    public function autowireAbstractToConstructorInjectionRector(\_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoperb75b35f52b74\Rector\Symfony\ServiceMapProvider $applicationServiceMapProvider) : void
    {
        $this->propertyNaming = $propertyNaming;
        $this->applicationServiceMapProvider = $applicationServiceMapProvider;
    }
    protected function processMethodCallNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $serviceType = $this->getServiceTypeFromMethodCallArgument($methodCall);
        if (!$serviceType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return null;
        }
        $propertyName = $this->propertyNaming->fqnToVariableName($serviceType);
        $classLike = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->addConstructorDependencyToClass($classLike, $serviceType, $propertyName);
        return $this->createPropertyFetch('this', $propertyName);
    }
    private function getServiceTypeFromMethodCallArgument(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (!isset($methodCall->args[0])) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $argument = $methodCall->args[0]->value;
        $serviceMap = $this->applicationServiceMapProvider->provide();
        if ($argument instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            return $serviceMap->getServiceType($argument->value);
        }
        if ($argument instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch && $argument->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            $className = $this->getName($argument->class);
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($className);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
}
