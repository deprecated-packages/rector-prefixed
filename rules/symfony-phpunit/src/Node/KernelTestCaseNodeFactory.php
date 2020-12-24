<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\SymfonyPHPUnit\Node;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator;
use _PhpScoperb75b35f52b74\Rector\SymfonyPHPUnit\Naming\ServiceNaming;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator $phpUnitTypeDeclarationDecorator, \_PhpScoperb75b35f52b74\Rector\SymfonyPHPUnit\Naming\ServiceNaming $serviceNaming)
    {
        $this->phpUnitTypeDeclarationDecorator = $phpUnitTypeDeclarationDecorator;
        $this->nodeFactory = $nodeFactory;
        $this->serviceNaming = $serviceNaming;
    }
    /**
     * @param string[] $serviceTypes
     */
    public function createSetUpClassMethodWithGetTypes(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, array $serviceTypes) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $assigns = $this->createSelfContainerGetWithTypeAssigns($class, $serviceTypes);
        if ($assigns === []) {
            return null;
        }
        $stmts = \array_merge([new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('parent'), \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::SET_UP)], $assigns);
        $classMethodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::SET_UP);
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
    public function createPrivatePropertiesFromTypes(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, array $serviceTypes) : array
    {
        $properties = [];
        /** @var string $className */
        $className = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($serviceTypes as $serviceType) {
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($serviceType);
            // skip existing properties
            if (\property_exists($className, $propertyName)) {
                continue;
            }
            $serviceType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($serviceType);
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
    public function createSelfContainerGetWithTypeAssigns(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, array $serviceTypes) : array
    {
        $stmts = [];
        /** @var string $className */
        $className = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($serviceTypes as $serviceType) {
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($serviceType);
            // skip existing properties
            if (\property_exists($className, $propertyName)) {
                continue;
            }
            $propertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), $propertyName);
            $methodCall = $this->createSelfContainerGetWithTypeMethodCall($serviceType);
            $assign = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($propertyFetch, $methodCall);
            $stmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
        }
        return $stmts;
    }
    private function createSelfContainerGetWithTypeMethodCall(string $serviceType) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        $staticPropertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('self'), 'container');
        $methodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($staticPropertyFetch, 'get');
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($serviceType, '_') && !\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($serviceType, '\\')) {
            // keep string
            $getArgumentValue = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($serviceType);
        } else {
            $getArgumentValue = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($serviceType), 'class');
        }
        $methodCall->args[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($getArgumentValue);
        return $methodCall;
    }
}
