<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ClassBuilder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ParamBuilder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
final class UniqueObjectFactoryFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->propertyNaming = $propertyNaming;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->nodeFactory = $nodeFactory;
    }
    public function createFactoryClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, \_PhpScopere8e811afab72\PHPStan\Type\ObjectType $objectType) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        $className = $this->nodeNameResolver->getName($class);
        if ($className === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $name = $className . 'Factory';
        $shortName = $this->resolveClassShortName($name);
        $factoryClassBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ClassBuilder($shortName);
        $factoryClassBuilder->makeFinal();
        $properties = $this->createPropertiesFromTypes($objectType);
        $factoryClassBuilder->addStmts($properties);
        // constructor
        $constructorClassMethod = $this->createConstructMethod($objectType);
        $factoryClassBuilder->addStmt($constructorClassMethod);
        // create
        $classMethod = $this->createCreateMethod($class, $className, $properties);
        $factoryClassBuilder->addStmt($classMethod);
        return $factoryClassBuilder->getNode();
    }
    private function resolveClassShortName(string $name) : string
    {
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($name, '\\')) {
            return (string) \_PhpScopere8e811afab72\Nette\Utils\Strings::after($name, '\\', -1);
        }
        return $name;
    }
    /**
     * @return Property[]
     */
    private function createPropertiesFromTypes(\_PhpScopere8e811afab72\PHPStan\Type\ObjectType $objectType) : array
    {
        $properties = [];
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $property = $this->nodeFactory->createPrivateProperty($propertyName);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->changeVarType($objectType);
        $properties[] = $property;
        return $properties;
    }
    private function createConstructMethod(\_PhpScopere8e811afab72\PHPStan\Type\ObjectType $objectType) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $paramBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ParamBuilder($propertyName);
        $typeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($objectType);
        if ($typeNode !== null) {
            $paramBuilder->setType($typeNode);
        }
        $params = [$paramBuilder->getNode()];
        $assigns = $this->createAssignsFromParams($params);
        $methodBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $methodBuilder->makePublic();
        $methodBuilder->addParams($params);
        $methodBuilder->addStmts($assigns);
        return $methodBuilder->getNode();
    }
    /**
     * @param Property[] $properties
     */
    private function createCreateMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, string $className, array $properties) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $new = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($className));
        $constructClassMethod = $class->getMethod(\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $params = [];
        if ($constructClassMethod !== null) {
            foreach ($constructClassMethod->params as $param) {
                $params[] = $param;
                $new->args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($param->var);
            }
        }
        foreach ($properties as $property) {
            $propertyName = $this->nodeNameResolver->getName($property);
            $propertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $propertyName);
            $new->args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($propertyFetch);
        }
        $return = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_($new);
        $methodBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder('create');
        $methodBuilder->setReturnType(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($className));
        $methodBuilder->makePublic();
        $methodBuilder->addStmt($return);
        $methodBuilder->addParams($params);
        return $methodBuilder->getNode();
    }
    /**
     * @param Param[] $params
     *
     * @return Assign[]
     */
    private function createAssignsFromParams(array $params) : array
    {
        $assigns = [];
        /** @var Param $param */
        foreach ($params as $param) {
            $propertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $param->var->name);
            $assigns[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($propertyFetch, new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($param->var->name));
        }
        return $assigns;
    }
}
