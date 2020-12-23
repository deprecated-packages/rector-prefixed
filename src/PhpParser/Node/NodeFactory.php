<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node;

use _PhpScoper0a2ac50786fa\PhpParser\BuilderFactory;
use _PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Const_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Error;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\NullableType;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse;
use _PhpScoper0a2ac50786fa\PhpParser\Node\UnionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedException;
use _PhpScoper0a2ac50786fa\Rector\Core\Php\PhpVersionProvider;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\ParamBuilder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\PropertyBuilder;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\StaticTypeMapper;
/**
 * @see \Rector\Core\Tests\PhpParser\Node\NodeFactoryTest
 */
final class NodeFactory
{
    /**
     * @var string
     */
    private const THIS = 'this';
    /**
     * @var string
     */
    private const REFERENCE_PARENT = 'parent';
    /**
     * @var string
     */
    private const REFERENCE_SELF = 'self';
    /**
     * @var string
     */
    private const REFERENCE_STATIC = 'static';
    /**
     * @var string[]
     */
    private const REFERENCES = [self::REFERENCE_STATIC, self::REFERENCE_PARENT, self::REFERENCE_SELF];
    /**
     * @var BuilderFactory
     */
    private $builderFactory;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\BuilderFactory $builderFactory, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \_PhpScoper0a2ac50786fa\Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->builderFactory = $builderFactory;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->phpVersionProvider = $phpVersionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * Creates "SomeClass::CONSTANT"
     */
    public function createShortClassConstFetch(string $shortClassName, string $constantName) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch
    {
        $name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($shortClassName);
        return $this->createClassConstFetchFromName($name, $constantName);
    }
    /**
     * Creates "\SomeClass::CONSTANT"
     */
    public function createClassConstFetch(string $className, string $constantName) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch
    {
        $classNameNode = \in_array($className, self::REFERENCES, \true) ? new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($className) : new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($className);
        return $this->createClassConstFetchFromName($classNameNode, $constantName);
    }
    /**
     * Creates "\SomeClass::class"
     */
    public function createClassConstReference(string $className) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->createClassConstFetch($className, 'class');
    }
    /**
     * Creates "['item', $variable]"
     *
     * @param mixed[] $items
     */
    public function createArray(array $items) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_
    {
        $arrayItems = [];
        $defaultKey = 0;
        foreach ($items as $key => $item) {
            $customKey = $key !== $defaultKey ? $key : null;
            $arrayItems[] = $this->createArrayItem($item, $customKey);
            ++$defaultKey;
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_($arrayItems);
    }
    /**
     * Creates "($args)"
     *
     * @param mixed[] $values
     * @return Arg[]
     */
    public function createArgs(array $values) : array
    {
        $normalizedValues = [];
        foreach ($values as $key => $value) {
            $normalizedValues[$key] = $this->normalizeArgValue($value);
        }
        return $this->builderFactory->args($normalizedValues);
    }
    /**
     * Creates $this->property = $property;
     */
    public function createPropertyAssignment(string $propertyName) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign
    {
        $variable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($propertyName);
        return $this->createPropertyAssignmentWithExpr($propertyName, $variable);
    }
    public function createPropertyAssignmentWithExpr(string $propertyName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign
    {
        $propertyFetch = $this->createPropertyFetch(self::THIS, $propertyName);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign($propertyFetch, $expr);
    }
    /**
     * @param mixed $argument
     */
    public function createArg($argument) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg
    {
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg(\_PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers::normalizeValue($argument));
    }
    public function createPublicMethod(string $name) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder($name);
        $methodBuilder->makePublic();
        return $methodBuilder->getNode();
    }
    public function createParamFromNameAndType(string $name, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Param
    {
        $paramBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\ParamBuilder($name);
        if ($type !== null) {
            $typeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type);
            if ($typeNode !== null) {
                $paramBuilder->setType($typeNode);
            }
        }
        return $paramBuilder->getNode();
    }
    public function createPublicInjectPropertyFromNameAndType(string $name, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
        $propertyBuilder->makePublic();
        $property = $propertyBuilder->getNode();
        $this->addPropertyType($property, $type);
        $this->decorateParentPropertyProperty($property);
        // add @inject
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($property);
        }
        $phpDocInfo->addBareTag('inject');
        return $property;
    }
    public function createPrivatePropertyFromNameAndType(string $name, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
        $propertyBuilder->makePrivate();
        $property = $propertyBuilder->getNode();
        $this->addPropertyType($property, $type);
        $this->decorateParentPropertyProperty($property);
        return $property;
    }
    /**
     * @param string|Expr $variable
     * @param mixed[] $arguments
     */
    public function createMethodCall($variable, string $method, array $arguments = []) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        if (\is_string($variable)) {
            $variable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($variable);
        }
        if ($variable instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
            $variable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch($variable->var, $variable->name);
        }
        if ($variable instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch) {
            $variable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch($variable->class, $variable->name);
        }
        if ($variable instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            $variable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($variable->var, $variable->name, $variable->args);
        }
        $methodCallNode = $this->builderFactory->methodCall($variable, $method, $arguments);
        $variable->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $methodCallNode);
        return $methodCallNode;
    }
    /**
     * @param string|Expr $variable
     */
    public function createPropertyFetch($variable, string $property) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch
    {
        if (\is_string($variable)) {
            $variable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($variable);
        }
        return $this->builderFactory->propertyFetch($variable, $property);
    }
    /**
     * @param Param[] $params
     */
    public function createParentConstructWithParams(array $params) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall
    {
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name(self::REFERENCE_PARENT), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT), $this->convertParamNodesToArgNodes($params));
    }
    public function createStaticProtectedPropertyWithDefault(string $name, \_PhpScoper0a2ac50786fa\PhpParser\Node $node) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
        $propertyBuilder->makeProtected();
        $propertyBuilder->makeStatic();
        $propertyBuilder->setDefault($node);
        $property = $propertyBuilder->getNode();
        $this->decorateParentPropertyProperty($property);
        return $property;
    }
    public function createProperty(string $name) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
        $property = $propertyBuilder->getNode();
        $this->decorateParentPropertyProperty($property);
        $this->phpDocInfoFactory->createFromNode($property);
        return $property;
    }
    public function createPrivateProperty(string $name) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
        $propertyBuilder->makePrivate();
        $property = $propertyBuilder->getNode();
        $this->decorateParentPropertyProperty($property);
        $this->phpDocInfoFactory->createFromNode($property);
        return $property;
    }
    public function createPublicProperty(string $name) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
        $propertyBuilder->makePublic();
        $property = $propertyBuilder->getNode();
        $this->decorateParentPropertyProperty($property);
        $this->phpDocInfoFactory->createFromNode($property);
        return $property;
    }
    /**
     * @param mixed $value
     */
    public function createPrivateClassConst(string $name, $value) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst
    {
        return $this->createClassConstant($name, $value, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
    }
    /**
     * @param mixed $value
     */
    public function createPublicClassConst(string $name, $value) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst
    {
        return $this->createClassConstant($name, $value, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC);
    }
    /**
     * @param Identifier|Name|NullableType|UnionType|null $typeNode
     */
    public function createGetterClassMethodFromNameAndType(string $propertyName, ?\_PhpScoper0a2ac50786fa\PhpParser\Node $typeNode) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        $getterMethod = 'get' . \ucfirst($propertyName);
        $methodBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder($getterMethod);
        $methodBuilder->makePublic();
        $propertyFetch = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable(self::THIS), $propertyName);
        $return = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_($propertyFetch);
        $methodBuilder->addStmt($return);
        if ($typeNode !== null) {
            $methodBuilder->setReturnType($typeNode);
        }
        return $methodBuilder->getNode();
    }
    /**
     * @todo decouple to StackNodeFactory
     * @param Expr[] $exprs
     */
    public function createConcat(array $exprs) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat
    {
        if (\count($exprs) < 2) {
            return null;
        }
        /** @var Expr $previousConcat */
        $previousConcat = \array_shift($exprs);
        foreach ($exprs as $expr) {
            $previousConcat = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat($previousConcat, $expr);
        }
        /** @var Concat $previousConcat */
        return $previousConcat;
    }
    public function createClosureFromClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure
    {
        $classMethodName = $this->nodeNameResolver->getName($classMethod);
        $args = $this->createArgs($classMethod->params);
        $methodCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable(self::THIS), $classMethodName, $args);
        $return = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_($methodCall);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure(['params' => $classMethod->params, 'stmts' => [$return], 'returnType' => $classMethod->returnType]);
    }
    /**
     * @param string[] $names
     * @return Use_[]
     */
    public function createUsesFromNames(array $names) : array
    {
        $uses = [];
        foreach ($names as $resolvedName) {
            $useUse = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($resolvedName));
            $uses[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_([$useUse]);
        }
        return $uses;
    }
    public function createStaticCall(string $class, string $method) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall
    {
        if (\in_array($class, self::REFERENCES, \true)) {
            $class = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($class);
        } else {
            $class = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($class);
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall($class, $method);
    }
    /**
     * @param mixed[] $arguments
     */
    public function createFuncCall(string $name, array $arguments) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall
    {
        $arguments = $this->createArgs($arguments);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($name), $arguments);
    }
    private function createClassConstFetchFromName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $className, string $constantName) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch
    {
        $classConstFetchNode = $this->builderFactory->classConstFetch($className, $constantName);
        $classConstFetchNode->class->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME, (string) $className);
        return $classConstFetchNode;
    }
    /**
     * @param mixed $item
     * @param string|int|null $key
     */
    private function createArrayItem($item, $key = null) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem
    {
        $arrayItem = null;
        if ($item instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable || $item instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall || $item instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall || $item instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall || $item instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat || $item instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar) {
            $arrayItem = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem($item);
        } elseif ($item instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
            $string = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_($item->toString());
            $arrayItem = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem($string);
        } elseif (\is_scalar($item) || $item instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_) {
            $itemValue = \_PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers::normalizeValue($item);
            $arrayItem = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem($itemValue);
        } elseif (\is_array($item)) {
            $arrayItem = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem($this->createArray($item));
        }
        if ($arrayItem !== null) {
            if ($key === null) {
                return $arrayItem;
            }
            $arrayItem->key = \_PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers::normalizeValue($key);
            return $arrayItem;
        }
        if ($item instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch) {
            $itemValue = \_PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers::normalizeValue($item);
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem($itemValue);
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedException(\sprintf('Not implemented yet. Go to "%s()" and add check for "%s" node.', __METHOD__, \is_object($item) ? \get_class($item) : $item));
    }
    /**
     * @param mixed $value
     * @return mixed|Error|Variable
     */
    private function normalizeArgValue($value)
    {
        if ($value instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Param) {
            return $value->var;
        }
        return $value;
    }
    private function addPropertyType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : void
    {
        if ($type === null) {
            return;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            $phpParserType = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type);
            if ($phpParserType !== null) {
                $property->type = $phpParserType;
                if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType) {
                    $phpDocInfo->changeVarType($type);
                }
                return;
            }
        }
        $phpDocInfo->changeVarType($type);
    }
    private function decorateParentPropertyProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : void
    {
        // complete property property parent, needed for other operations
        $propertyProperty = $property->props[0];
        $propertyProperty->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $property);
    }
    /**
     * @param Param[] $paramNodes
     * @return Arg[]
     */
    private function convertParamNodesToArgNodes(array $paramNodes) : array
    {
        $args = [];
        foreach ($paramNodes as $paramNode) {
            $args[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($paramNode->var);
        }
        return $args;
    }
    /**
     * @param mixed $value
     */
    private function createClassConstant(string $name, $value, int $modifier) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst
    {
        $value = \_PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers::normalizeValue($value);
        $const = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Const_($name, $value);
        $classConst = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst([$const]);
        $classConst->flags |= $modifier;
        // add @var type by default
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($value);
        if (!$staticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($classConst);
            $phpDocInfo->changeVarType($staticType);
        }
        return $classConst;
    }
}
