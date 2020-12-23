<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\SymfonyPHPUnit\Node;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator;
use _PhpScoper0a2ac50786fa\Rector\SymfonyPHPUnit\Naming\ServiceNaming;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper0a2ac50786fa\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator $phpUnitTypeDeclarationDecorator, \_PhpScoper0a2ac50786fa\Rector\SymfonyPHPUnit\Naming\ServiceNaming $serviceNaming)
    {
        $this->phpUnitTypeDeclarationDecorator = $phpUnitTypeDeclarationDecorator;
        $this->nodeFactory = $nodeFactory;
        $this->serviceNaming = $serviceNaming;
    }
    /**
     * @param string[] $serviceTypes
     */
    public function createSetUpClassMethodWithGetTypes(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, array $serviceTypes) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        $assigns = $this->createSelfContainerGetWithTypeAssigns($class, $serviceTypes);
        if ($assigns === []) {
            return null;
        }
        $stmts = \array_merge([new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('parent'), \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::SET_UP)], $assigns);
        $classMethodBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::SET_UP);
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
    public function createPrivatePropertiesFromTypes(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, array $serviceTypes) : array
    {
        $properties = [];
        /** @var string $className */
        $className = $class->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($serviceTypes as $serviceType) {
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($serviceType);
            // skip existing properties
            if (\property_exists($className, $propertyName)) {
                continue;
            }
            $serviceType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($serviceType);
            $properties[] = $this->nodeFactory->createPrivatePropertyFromNameAndType($propertyName, $serviceType);
        }
        return $properties;
    }
    /**
     * @param string[] $serviceTypes
     *
     * @return Expression[]
     *
     * E.g. "['SomeService']" → "$this->someService = self::$container->get(SomeService::class);"
     */
    public function createSelfContainerGetWithTypeAssigns(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, array $serviceTypes) : array
    {
        $stmts = [];
        /** @var string $className */
        $className = $class->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($serviceTypes as $serviceType) {
            $propertyName = $this->serviceNaming->resolvePropertyNameFromServiceType($serviceType);
            // skip existing properties
            if (\property_exists($className, $propertyName)) {
                continue;
            }
            $propertyFetch = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('this'), $propertyName);
            $methodCall = $this->createSelfContainerGetWithTypeMethodCall($serviceType);
            $assign = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign($propertyFetch, $methodCall);
            $stmts[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($assign);
        }
        return $stmts;
    }
    private function createSelfContainerGetWithTypeMethodCall(string $serviceType) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        $staticPropertyFetch = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('self'), 'container');
        $methodCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($staticPropertyFetch, 'get');
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($serviceType, '_') && !\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($serviceType, '\\')) {
            // keep string
            $getArgumentValue = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($serviceType);
        } else {
            $getArgumentValue = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($serviceType), 'class');
        }
        $methodCall->args[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($getArgumentValue);
        return $methodCall;
    }
}
