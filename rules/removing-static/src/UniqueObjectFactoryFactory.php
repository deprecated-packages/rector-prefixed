<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RemovingStatic;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ClassBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->propertyNaming = $propertyNaming;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->nodeFactory = $nodeFactory;
    }
    public function createFactoryClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_
    {
        $className = $this->nodeNameResolver->getName($class);
        if ($className === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $name = $className . 'Factory';
        $shortName = $this->resolveClassShortName($name);
        $factoryClassBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ClassBuilder($shortName);
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
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($name, '\\')) {
            return (string) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::after($name, '\\', -1);
        }
        return $name;
    }
    /**
     * @return Property[]
     */
    private function createPropertiesFromTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType) : array
    {
        $properties = [];
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $property = $this->nodeFactory->createPrivateProperty($propertyName);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->changeVarType($objectType);
        $properties[] = $property;
        return $properties;
    }
    private function createConstructMethod(\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $paramBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder($propertyName);
        $typeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($objectType);
        if ($typeNode !== null) {
            $paramBuilder->setType($typeNode);
        }
        $params = [$paramBuilder->getNode()];
        $assigns = $this->createAssignsFromParams($params);
        $methodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $methodBuilder->makePublic();
        $methodBuilder->addParams($params);
        $methodBuilder->addStmts($assigns);
        return $methodBuilder->getNode();
    }
    /**
     * @param Property[] $properties
     */
    private function createCreateMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, string $className, array $properties) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $new = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($className));
        $constructClassMethod = $class->getMethod(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $params = [];
        if ($constructClassMethod !== null) {
            foreach ($constructClassMethod->params as $param) {
                $params[] = $param;
                $new->args[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($param->var);
            }
        }
        foreach ($properties as $property) {
            $propertyName = $this->nodeNameResolver->getName($property);
            $propertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), $propertyName);
            $new->args[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($propertyFetch);
        }
        $return = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($new);
        $methodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder('create');
        $methodBuilder->setReturnType(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($className));
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
            $propertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), $param->var->name);
            $assigns[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($propertyFetch, new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($param->var->name));
        }
        return $assigns;
    }
}
