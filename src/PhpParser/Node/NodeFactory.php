<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node;

use _PhpScoperb75b35f52b74\PhpParser\BuilderFactory;
use _PhpScoperb75b35f52b74\PhpParser\BuilderHelpers;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Const_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Error;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse;
use _PhpScoperb75b35f52b74\PhpParser\Node\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException;
use _PhpScoperb75b35f52b74\Rector\Core\Php\PhpVersionProvider;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\PropertyBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\BuilderFactory $builderFactory, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \_PhpScoperb75b35f52b74\Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
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
    public function createShortClassConstFetch(string $shortClassName, string $constantName) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch
    {
        $name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($shortClassName);
        return $this->createClassConstFetchFromName($name, $constantName);
    }
    /**
     * Creates "\SomeClass::CONSTANT"
     */
    public function createClassConstFetch(string $className, string $constantName) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch
    {
        $classNameNode = \in_array($className, self::REFERENCES, \true) ? new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($className) : new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($className);
        return $this->createClassConstFetchFromName($classNameNode, $constantName);
    }
    /**
     * Creates "\SomeClass::class"
     */
    public function createClassConstReference(string $className) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->createClassConstFetch($className, 'class');
    }
    /**
     * Creates "['item', $variable]"
     *
     * @param mixed[] $items
     */
    public function createArray(array $items) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_
    {
        $arrayItems = [];
        $defaultKey = 0;
        foreach ($items as $key => $item) {
            $customKey = $key !== $defaultKey ? $key : null;
            $arrayItems[] = $this->createArrayItem($item, $customKey);
            ++$defaultKey;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_($arrayItems);
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
    public function createPropertyAssignment(string $propertyName) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        $variable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($propertyName);
        return $this->createPropertyAssignmentWithExpr($propertyName, $variable);
    }
    public function createPropertyAssignmentWithExpr(string $propertyName, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        $propertyFetch = $this->createPropertyFetch(self::THIS, $propertyName);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($propertyFetch, $expr);
    }
    /**
     * @param mixed $argument
     */
    public function createArg($argument) : \_PhpScoperb75b35f52b74\PhpParser\Node\Arg
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(\_PhpScoperb75b35f52b74\PhpParser\BuilderHelpers::normalizeValue($argument));
    }
    public function createPublicMethod(string $name) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder($name);
        $methodBuilder->makePublic();
        return $methodBuilder->getNode();
    }
    public function createParamFromNameAndType(string $name, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PhpParser\Node\Param
    {
        $paramBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder($name);
        if ($type !== null) {
            $typeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type);
            if ($typeNode !== null) {
                $paramBuilder->setType($typeNode);
            }
        }
        return $paramBuilder->getNode();
    }
    public function createPublicInjectPropertyFromNameAndType(string $name, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
        $propertyBuilder->makePublic();
        $property = $propertyBuilder->getNode();
        $this->addPropertyType($property, $type);
        $this->decorateParentPropertyProperty($property);
        // add @inject
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($property);
        }
        $phpDocInfo->addBareTag('inject');
        return $property;
    }
    public function createPrivatePropertyFromNameAndType(string $name, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
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
    public function createMethodCall($variable, string $method, array $arguments = []) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        if (\is_string($variable)) {
            $variable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($variable);
        }
        if ($variable instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            $variable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch($variable->var, $variable->name);
        }
        if ($variable instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) {
            $variable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch($variable->class, $variable->name);
        }
        if ($variable instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            $variable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($variable->var, $variable->name, $variable->args);
        }
        $methodCallNode = $this->builderFactory->methodCall($variable, $method, $arguments);
        $variable->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $methodCallNode);
        return $methodCallNode;
    }
    /**
     * @param string|Expr $variable
     */
    public function createPropertyFetch($variable, string $property) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch
    {
        if (\is_string($variable)) {
            $variable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($variable);
        }
        return $this->builderFactory->propertyFetch($variable, $property);
    }
    /**
     * @param Param[] $params
     */
    public function createParentConstructWithParams(array $params) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name(self::REFERENCE_PARENT), new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT), $this->convertParamNodesToArgNodes($params));
    }
    public function createStaticProtectedPropertyWithDefault(string $name, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
        $propertyBuilder->makeProtected();
        $propertyBuilder->makeStatic();
        $propertyBuilder->setDefault($node);
        $property = $propertyBuilder->getNode();
        $this->decorateParentPropertyProperty($property);
        return $property;
    }
    public function createProperty(string $name) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
        $property = $propertyBuilder->getNode();
        $this->decorateParentPropertyProperty($property);
        $this->phpDocInfoFactory->createFromNode($property);
        return $property;
    }
    public function createPrivateProperty(string $name) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
        $propertyBuilder->makePrivate();
        $property = $propertyBuilder->getNode();
        $this->decorateParentPropertyProperty($property);
        $this->phpDocInfoFactory->createFromNode($property);
        return $property;
    }
    public function createPublicProperty(string $name) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\PropertyBuilder($name);
        $propertyBuilder->makePublic();
        $property = $propertyBuilder->getNode();
        $this->decorateParentPropertyProperty($property);
        $this->phpDocInfoFactory->createFromNode($property);
        return $property;
    }
    /**
     * @param mixed $value
     */
    public function createPrivateClassConst(string $name, $value) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst
    {
        return $this->createClassConstant($name, $value, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
    }
    /**
     * @param mixed $value
     */
    public function createPublicClassConst(string $name, $value) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst
    {
        return $this->createClassConstant($name, $value, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC);
    }
    /**
     * @param Identifier|Name|NullableType|UnionType|null $typeNode
     */
    public function createGetterClassMethodFromNameAndType(string $propertyName, ?\_PhpScoperb75b35f52b74\PhpParser\Node $typeNode) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $getterMethod = 'get' . \ucfirst($propertyName);
        $methodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder($getterMethod);
        $methodBuilder->makePublic();
        $propertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable(self::THIS), $propertyName);
        $return = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($propertyFetch);
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
    public function createConcat(array $exprs) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat
    {
        if (\count($exprs) < 2) {
            return null;
        }
        /** @var Expr $previousConcat */
        $previousConcat = \array_shift($exprs);
        foreach ($exprs as $expr) {
            $previousConcat = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat($previousConcat, $expr);
        }
        /** @var Concat $previousConcat */
        return $previousConcat;
    }
    public function createClosureFromClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure
    {
        $classMethodName = $this->nodeNameResolver->getName($classMethod);
        $args = $this->createArgs($classMethod->params);
        $methodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable(self::THIS), $classMethodName, $args);
        $return = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($methodCall);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure(['params' => $classMethod->params, 'stmts' => [$return], 'returnType' => $classMethod->returnType]);
    }
    /**
     * @param string[] $names
     * @return Use_[]
     */
    public function createUsesFromNames(array $names) : array
    {
        $uses = [];
        foreach ($names as $resolvedName) {
            $useUse = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($resolvedName));
            $uses[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_([$useUse]);
        }
        return $uses;
    }
    public function createStaticCall(string $class, string $method) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall
    {
        if (\in_array($class, self::REFERENCES, \true)) {
            $class = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($class);
        } else {
            $class = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($class);
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall($class, $method);
    }
    /**
     * @param mixed[] $arguments
     */
    public function createFuncCall(string $name, array $arguments) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        $arguments = $this->createArgs($arguments);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($name), $arguments);
    }
    private function createClassConstFetchFromName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $className, string $constantName) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch
    {
        $classConstFetchNode = $this->builderFactory->classConstFetch($className, $constantName);
        $classConstFetchNode->class->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME, (string) $className);
        return $classConstFetchNode;
    }
    /**
     * @param mixed $item
     * @param string|int|null $key
     */
    private function createArrayItem($item, $key = null) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem
    {
        $arrayItem = null;
        if ($item instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable || $item instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall || $item instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall || $item instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall || $item instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat || $item instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar) {
            $arrayItem = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem($item);
        } elseif ($item instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
            $string = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($item->toString());
            $arrayItem = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem($string);
        } elseif (\is_scalar($item) || $item instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
            $itemValue = \_PhpScoperb75b35f52b74\PhpParser\BuilderHelpers::normalizeValue($item);
            $arrayItem = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem($itemValue);
        } elseif (\is_array($item)) {
            $arrayItem = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem($this->createArray($item));
        }
        if ($arrayItem !== null) {
            if ($key === null) {
                return $arrayItem;
            }
            $arrayItem->key = \_PhpScoperb75b35f52b74\PhpParser\BuilderHelpers::normalizeValue($key);
            return $arrayItem;
        }
        if ($item instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch) {
            $itemValue = \_PhpScoperb75b35f52b74\PhpParser\BuilderHelpers::normalizeValue($item);
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem($itemValue);
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException(\sprintf('Not implemented yet. Go to "%s()" and add check for "%s" node.', __METHOD__, \is_object($item) ? \get_class($item) : $item));
    }
    /**
     * @param mixed $value
     * @return mixed|Error|Variable
     */
    private function normalizeArgValue($value)
    {
        if ($value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Param) {
            return $value->var;
        }
        return $value;
    }
    private function addPropertyType(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : void
    {
        if ($type === null) {
            return;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            $phpParserType = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type);
            if ($phpParserType !== null) {
                $property->type = $phpParserType;
                if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType) {
                    $phpDocInfo->changeVarType($type);
                }
                return;
            }
        }
        $phpDocInfo->changeVarType($type);
    }
    private function decorateParentPropertyProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : void
    {
        // complete property property parent, needed for other operations
        $propertyProperty = $property->props[0];
        $propertyProperty->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $property);
    }
    /**
     * @param Param[] $paramNodes
     * @return Arg[]
     */
    private function convertParamNodesToArgNodes(array $paramNodes) : array
    {
        $args = [];
        foreach ($paramNodes as $paramNode) {
            $args[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($paramNode->var);
        }
        return $args;
    }
    /**
     * @param mixed $value
     */
    private function createClassConstant(string $name, $value, int $modifier) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst
    {
        $value = \_PhpScoperb75b35f52b74\PhpParser\BuilderHelpers::normalizeValue($value);
        $const = new \_PhpScoperb75b35f52b74\PhpParser\Node\Const_($name, $value);
        $classConst = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst([$const]);
        $classConst->flags |= $modifier;
        // add @var type by default
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($value);
        if (!$staticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            $phpDocInfo = $this->phpDocInfoFactory->createEmpty($classConst);
            $phpDocInfo->changeVarType($staticType);
        }
        return $classConst;
    }
}
