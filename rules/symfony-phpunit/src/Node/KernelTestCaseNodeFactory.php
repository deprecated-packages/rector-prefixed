<?php

declare (strict_types=1);
namespace Rector\SymfonyPHPUnit\Node;

use _PhpScoper17db12703726\Nette\Utils\Strings;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ObjectType;
use Rector\Core\PhpParser\Builder\MethodBuilder;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator;
use Rector\SymfonyPHPUnit\Naming\ServiceNaming;
final class KernelTestCaseNodeFactory
{
    /**
     * @var PHPUnitTypeDeclarationDecorator
     */
    private $phpUnitTypeDeclarationDecorator;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var ServiceNaming
     */
    private $serviceNaming;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator $phpUnitTypeDeclarationDecorator, \Rector\SymfonyPHPUnit\Naming\ServiceNaming $serviceNaming)
    {
        $this->phpUnitTypeDeclarationDecorator = $phpUnitTypeDeclarationDecorator;
        $this->nodeFactory = $nodeFactory;
        $this->serviceNaming = $serviceNaming;
    }
    /**
     * @param string[] $serviceTypes
     */
    public function createSetUpClassMethodWithGetTypes(\PhpParser\Node\Stmt\Class_ $class, array $serviceTypes) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        $assigns = $this->createSelfContainerGetWithTypeAssigns($class, $serviceTypes);
        if ($assigns === []) {
            return null;
        }
        $stmts = \array_merge([new \PhpParser\Node\Expr\StaticCall(new \PhpParser\Node\Name('parent'), \Rector\Core\ValueObject\MethodName::SET_UP)], $assigns);
        $classMethodBuilder = new \Rector\Core\PhpParser\Builder\MethodBuilder(\Rector\Core\ValueObject\MethodName::SET_UP);
        $classMethodBuilder->makeProtected();
        $classMethodBuilder->addStmts($stmts);
        $classMethod = $classMethodBuilder->getNode();
        $this->phpUnitTypeDeclarationDecorator->decorate($classMethod);
        return $classMethod;
    }
    /**
     * @param string[] $serviceTypes
     *
     * @return Property[]
     */
    public function createPrivatePropertiesFromTypes(\PhpParser\Node\Stmt\Class_ $class, array $serviceTypes) : array
    {
        $properties = [];
        /** @var string $className */
        $className = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($serviceTypes as $serviceType) {
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($serviceType);
            // skip existing properties
            if (\property_exists($className, $propertyName)) {
                continue;
            }
            $serviceType = new \PHPStan\Type\ObjectType($serviceType);
            $properties[] = $this->nodeFactory->createPrivatePropertyFromNameAndType($propertyName, $serviceType);
        }
        return $properties;
    }
    /**
     * @param string[] $serviceTypes
     *
     * @return Expression[]
     *
     * E.g. "['SomeService']" → "$this->someService = $this->getService(SomeService::class);"
     */
    public function createSelfContainerGetWithTypeAssigns(\PhpParser\Node\Stmt\Class_ $class, array $serviceTypes) : array
    {
        $stmts = [];
        /** @var string $className */
        $className = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($serviceTypes as $serviceType) {
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($serviceType);
            // skip existing properties
            if (\property_exists($className, $propertyName)) {
                continue;
            }
            $propertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $propertyName);
            $methodCall = $this->createSelfContainerGetWithTypeMethodCall($serviceType);
            $assign = new \PhpParser\Node\Expr\Assign($propertyFetch, $methodCall);
            $stmts[] = new \PhpParser\Node\Stmt\Expression($assign);
        }
        return $stmts;
    }
    private function createSelfContainerGetWithTypeMethodCall(string $serviceType) : \PhpParser\Node\Expr\MethodCall
    {
        $staticPropertyFetch = new \PhpParser\Node\Expr\StaticPropertyFetch(new \PhpParser\Node\Name('self'), 'container');
        $methodCall = new \PhpParser\Node\Expr\MethodCall($staticPropertyFetch, 'get');
        if (\_PhpScoper17db12703726\Nette\Utils\Strings::contains($serviceType, '_') && !\_PhpScoper17db12703726\Nette\Utils\Strings::contains($serviceType, '\\')) {
            // keep string
            $getArgumentValue = new \PhpParser\Node\Scalar\String_($serviceType);
        } else {
            $getArgumentValue = new \PhpParser\Node\Expr\ClassConstFetch(new \PhpParser\Node\Name\FullyQualified($serviceType), 'class');
        }
        $methodCall->args[] = new \PhpParser\Node\Arg($getArgumentValue);
        return $methodCall;
    }
}
