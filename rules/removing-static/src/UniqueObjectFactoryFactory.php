<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\RemovingStatic;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ClassBuilder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ParamBuilder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->propertyNaming = $propertyNaming;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->nodeFactory = $nodeFactory;
    }
    public function createFactoryClass(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType $objectType) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_
    {
        $className = $this->nodeNameResolver->getName($class);
        if ($className === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $name = $className . 'Factory';
        $shortName = $this->resolveClassShortName($name);
        $factoryClassBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ClassBuilder($shortName);
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
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($name, '\\')) {
            return (string) \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($name, '\\', -1);
        }
        return $name;
    }
    /**
     * @return Property[]
     */
    private function createPropertiesFromTypes(\_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType $objectType) : array
    {
        $properties = [];
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $property = $this->nodeFactory->createPrivateProperty($propertyName);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->changeVarType($objectType);
        $properties[] = $property;
        return $properties;
    }
    private function createConstructMethod(\_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType $objectType) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $propertyName = $this->propertyNaming->fqnToVariableName($objectType);
        $paramBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ParamBuilder($propertyName);
        $typeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($objectType);
        if ($typeNode !== null) {
            $paramBuilder->setType($typeNode);
        }
        $params = [$paramBuilder->getNode()];
        $assigns = $this->createAssignsFromParams($params);
        $methodBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $methodBuilder->makePublic();
        $methodBuilder->addParams($params);
        $methodBuilder->addStmts($assigns);
        return $methodBuilder->getNode();
    }
    /**
     * @param Property[] $properties
     */
    private function createCreateMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, string $className, array $properties) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $new = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($className));
        $constructClassMethod = $class->getMethod(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        $params = [];
        if ($constructClassMethod !== null) {
            foreach ($constructClassMethod->params as $param) {
                $params[] = $param;
                $new->args[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($param->var);
            }
        }
        foreach ($properties as $property) {
            $propertyName = $this->nodeNameResolver->getName($property);
            $propertyFetch = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('this'), $propertyName);
            $new->args[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($propertyFetch);
        }
        $return = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_($new);
        $methodBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder('create');
        $methodBuilder->setReturnType(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($className));
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
            $propertyFetch = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('this'), $param->var->name);
            $assigns[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($propertyFetch, new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($param->var->name));
        }
        return $assigns;
    }
}
