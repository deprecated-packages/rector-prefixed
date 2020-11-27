<?php

declare (strict_types=1);
namespace Rector\RemovingStatic;

use _PhpScoper006a73f0e455\Nette\Utils\Strings;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Builder\ClassBuilder;
use Rector\Core\PhpParser\Builder\MethodBuilder;
use Rector\Core\PhpParser\Builder\ParamBuilder;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Core\ValueObject\MethodName;
use Rector\Naming\Naming\PropertyNaming;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\StaticTypeMapper\StaticTypeMapper;
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
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Naming\Naming\PropertyNaming $propertyNaming, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->propertyNaming = $propertyNaming;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->nodeFactory = $nodeFactory;
    }
    public function createFactoryClass(\PhpParser\Node\Stmt\Class_ $class, \PHPStan\Type\ObjectType $objectType) : \PhpParser\Node\Stmt\Class_
    {
        $className = $this->nodeNameResolver->getName($class);
        if ($className === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $name = $className . 'Factory';
        $shortName = $this->resolveClassShortName($name);
        $factoryClassBuilder = new \Rector\Core\PhpParser\Builder\ClassBuilder($shortName);
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
        if (\_PhpScoper006a73f0e455\Nette\Utils\Strings::contains($name, '\\')) {
            return (string) \_PhpScoper006a73f0e455\Nette\Utils\Strings::after($name, '\\', -1);
        }
        return $name;
    }
    /**
     * @return Property[]
     */
    private function createPropertiesFromTypes(\PHPStan\Type\ObjectType $objectType) : array
    {
        $properties = [];
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $property = $this->nodeFactory->createPrivateProperty($propertyName);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->changeVarType($objectType);
        $properties[] = $property;
        return $properties;
    }
    private function createConstructMethod(\PHPStan\Type\ObjectType $objectType) : \PhpParser\Node\Stmt\ClassMethod
    {
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $paramBuilder = new \Rector\Core\PhpParser\Builder\ParamBuilder($propertyName);
        $typeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($objectType);
        if ($typeNode !== null) {
            $paramBuilder->setType($typeNode);
        }
        $params = [$paramBuilder->getNode()];
        $assigns = $this->createAssignsFromParams($params);
        $methodBuilder = new \Rector\Core\PhpParser\Builder\MethodBuilder(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $methodBuilder->makePublic();
        $methodBuilder->addParams($params);
        $methodBuilder->addStmts($assigns);
        return $methodBuilder->getNode();
    }
    /**
     * @param Property[] $properties
     */
    private function createCreateMethod(\PhpParser\Node\Stmt\Class_ $class, string $className, array $properties) : \PhpParser\Node\Stmt\ClassMethod
    {
        $new = new \PhpParser\Node\Expr\New_(new \PhpParser\Node\Name\FullyQualified($className));
        $constructClassMethod = $class->getMethod(\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $params = [];
        if ($constructClassMethod !== null) {
            foreach ($constructClassMethod->params as $param) {
                $params[] = $param;
                $new->args[] = new \PhpParser\Node\Arg($param->var);
            }
        }
        foreach ($properties as $property) {
            $propertyName = $this->nodeNameResolver->getName($property);
            if (!\is_string($propertyName)) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $propertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $propertyName);
            $new->args[] = new \PhpParser\Node\Arg($propertyFetch);
        }
        $return = new \PhpParser\Node\Stmt\Return_($new);
        $methodBuilder = new \Rector\Core\PhpParser\Builder\MethodBuilder('create');
        $methodBuilder->setReturnType(new \PhpParser\Node\Name\FullyQualified($className));
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
            $propertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), $param->var->name);
            $assigns[] = new \PhpParser\Node\Expr\Assign($propertyFetch, new \PhpParser\Node\Expr\Variable($param->var->name));
        }
        return $assigns;
    }
}
