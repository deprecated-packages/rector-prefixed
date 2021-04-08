<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Node;

use PhpParser\BuilderFactory;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Const_;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\Cast;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\Error;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
use PhpParser\Node\UnionType;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Configuration\CurrentNodeProvider;
use Rector\Core\Exception\NotImplementedYetException;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\ValueObject\MethodName;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\ValueObject\PropertyMetadata;
use Rector\StaticTypeMapper\StaticTypeMapper;
use RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\MethodBuilder;
use RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\ParamBuilder;
use RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\PropertyBuilder;
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
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    /**
     * @var CurrentNodeProvider
     */
    private $currentNodeProvider;
    public function __construct(\PhpParser\BuilderFactory $builderFactory, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger, \Rector\Core\Configuration\CurrentNodeProvider $currentNodeProvider)
    {
        $this->builderFactory = $builderFactory;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->phpVersionProvider = $phpVersionProvider;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->phpDocTypeChanger = $phpDocTypeChanger;
        $this->currentNodeProvider = $currentNodeProvider;
    }
    /**
     * Creates "SomeClass::CONSTANT"
     */
    public function createShortClassConstFetch(string $shortClassName, string $constantName) : \PhpParser\Node\Expr\ClassConstFetch
    {
        $name = new \PhpParser\Node\Name($shortClassName);
        return $this->createClassConstFetchFromName($name, $constantName);
    }
    /**
     * Creates "\SomeClass::CONSTANT"
     */
    public function createClassConstFetch(string $className, string $constantName) : \PhpParser\Node\Expr\ClassConstFetch
    {
        $classNameNode = \in_array($className, self::REFERENCES, \true) ? new \PhpParser\Node\Name($className) : new \PhpParser\Node\Name\FullyQualified($className);
        return $this->createClassConstFetchFromName($classNameNode, $constantName);
    }
    /**
     * Creates "\SomeClass::class"
     */
    public function createClassConstReference(string $className) : \PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->createClassConstFetch($className, 'class');
    }
    /**
     * Creates "['item', $variable]"
     *
     * @param mixed[] $items
     */
    public function createArray(array $items) : \PhpParser\Node\Expr\Array_
    {
        $arrayItems = [];
        $defaultKey = 0;
        foreach ($items as $key => $item) {
            $customKey = $key !== $defaultKey ? $key : null;
            $arrayItems[] = $this->createArrayItem($item, $customKey);
            ++$defaultKey;
        }
        return new \PhpParser\Node\Expr\Array_($arrayItems);
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
    public function createPropertyAssignment(string $propertyName) : \PhpParser\Node\Expr\Assign
    {
        $variable = new \PhpParser\Node\Expr\Variable($propertyName);
        return $this->createPropertyAssignmentWithExpr($propertyName, $variable);
    }
    public function createPropertyAssignmentWithExpr(string $propertyName, \PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr\Assign
    {
        $propertyFetch = $this->createPropertyFetch(self::THIS, $propertyName);
        return new \PhpParser\Node\Expr\Assign($propertyFetch, $expr);
    }
    /**
     * @param mixed $argument
     */
    public function createArg($argument) : \PhpParser\Node\Arg
    {
        return new \PhpParser\Node\Arg(\PhpParser\BuilderHelpers::normalizeValue($argument));
    }
    public function createPublicMethod(string $name) : \PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\MethodBuilder($name);
        $methodBuilder->makePublic();
        return $methodBuilder->getNode();
    }
    public function createParamFromNameAndType(string $name, ?\PHPStan\Type\Type $type) : \PhpParser\Node\Param
    {
        $paramBuilder = new \RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\ParamBuilder($name);
        if ($type !== null) {
            $typeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type);
            if ($typeNode !== null) {
                $paramBuilder->setType($typeNode);
            }
        }
        return $paramBuilder->getNode();
    }
    public function createPublicInjectPropertyFromNameAndType(string $name, ?\PHPStan\Type\Type $type) : \PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\PropertyBuilder($name);
        $propertyBuilder->makePublic();
        $property = $propertyBuilder->getNode();
        $this->addPropertyType($property, $type);
        // add @inject
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $phpDocInfo->addPhpDocTagNode(new \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode('@inject', new \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode('')));
        return $property;
    }
    public function createPrivatePropertyFromNameAndType(string $name, ?\PHPStan\Type\Type $type) : \PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\PropertyBuilder($name);
        $propertyBuilder->makePrivate();
        $property = $propertyBuilder->getNode();
        $this->addPropertyType($property, $type);
        return $property;
    }
    /**
     * @param mixed[] $arguments
     */
    public function createLocalMethodCall(string $method, array $arguments = []) : \PhpParser\Node\Expr\MethodCall
    {
        $variable = new \PhpParser\Node\Expr\Variable('this');
        return $this->createMethodCall($variable, $method, $arguments);
    }
    /**
     * @param string|Expr $variable
     * @param mixed[] $arguments
     */
    public function createMethodCall($variable, string $method, array $arguments = []) : \PhpParser\Node\Expr\MethodCall
    {
        if (\is_string($variable)) {
            $variable = new \PhpParser\Node\Expr\Variable($variable);
        }
        if ($variable instanceof \PhpParser\Node\Expr\PropertyFetch) {
            $variable = new \PhpParser\Node\Expr\PropertyFetch($variable->var, $variable->name);
        }
        if ($variable instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
            $variable = new \PhpParser\Node\Expr\StaticPropertyFetch($variable->class, $variable->name);
        }
        if ($variable instanceof \PhpParser\Node\Expr\MethodCall) {
            $variable = new \PhpParser\Node\Expr\MethodCall($variable->var, $variable->name, $variable->args);
        }
        return $this->builderFactory->methodCall($variable, $method, $arguments);
    }
    /**
     * @param string|Expr $variable
     */
    public function createPropertyFetch($variable, string $property) : \PhpParser\Node\Expr\PropertyFetch
    {
        if (\is_string($variable)) {
            $variable = new \PhpParser\Node\Expr\Variable($variable);
        }
        return $this->builderFactory->propertyFetch($variable, $property);
    }
    /**
     * @param Param[] $params
     */
    public function createParentConstructWithParams(array $params) : \PhpParser\Node\Expr\StaticCall
    {
        return new \PhpParser\Node\Expr\StaticCall(new \PhpParser\Node\Name(self::REFERENCE_PARENT), new \PhpParser\Node\Identifier(\Rector\Core\ValueObject\MethodName::CONSTRUCT), $this->createArgsFromParams($params));
    }
    public function createStaticProtectedPropertyWithDefault(string $name, \PhpParser\Node $node) : \PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\PropertyBuilder($name);
        $propertyBuilder->makeProtected();
        $propertyBuilder->makeStatic();
        $propertyBuilder->setDefault($node);
        return $propertyBuilder->getNode();
    }
    public function createProperty(string $name) : \PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\PropertyBuilder($name);
        $property = $propertyBuilder->getNode();
        $this->phpDocInfoFactory->createFromNode($property);
        return $property;
    }
    public function createPrivateProperty(string $name) : \PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\PropertyBuilder($name);
        $propertyBuilder->makePrivate();
        $property = $propertyBuilder->getNode();
        $this->phpDocInfoFactory->createFromNode($property);
        return $property;
    }
    public function createPublicProperty(string $name) : \PhpParser\Node\Stmt\Property
    {
        $propertyBuilder = new \RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\PropertyBuilder($name);
        $propertyBuilder->makePublic();
        $property = $propertyBuilder->getNode();
        $this->phpDocInfoFactory->createFromNode($property);
        return $property;
    }
    /**
     * @param mixed $value
     */
    public function createPrivateClassConst(string $name, $value) : \PhpParser\Node\Stmt\ClassConst
    {
        return $this->createClassConstant($name, $value, \PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
    }
    /**
     * @param mixed $value
     */
    public function createPublicClassConst(string $name, $value) : \PhpParser\Node\Stmt\ClassConst
    {
        return $this->createClassConstant($name, $value, \PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC);
    }
    /**
     * @param Identifier|Name|NullableType|UnionType|null $typeNode
     */
    public function createGetterClassMethodFromNameAndType(string $propertyName, ?\PhpParser\Node $typeNode) : \PhpParser\Node\Stmt\ClassMethod
    {
        $getterMethod = 'get' . \ucfirst($propertyName);
        $methodBuilder = new \RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\MethodBuilder($getterMethod);
        $methodBuilder->makePublic();
        $propertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable(self::THIS), $propertyName);
        $return = new \PhpParser\Node\Stmt\Return_($propertyFetch);
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
    public function createConcat(array $exprs) : ?\PhpParser\Node\Expr\BinaryOp\Concat
    {
        if (\count($exprs) < 2) {
            return null;
        }
        /** @var Expr $previousConcat */
        $previousConcat = \array_shift($exprs);
        foreach ($exprs as $expr) {
            $previousConcat = new \PhpParser\Node\Expr\BinaryOp\Concat($previousConcat, $expr);
        }
        /** @var Concat $previousConcat */
        return $previousConcat;
    }
    public function createClosureFromClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : \PhpParser\Node\Expr\Closure
    {
        $classMethodName = $this->nodeNameResolver->getName($classMethod);
        $args = $this->createArgs($classMethod->params);
        $methodCall = new \PhpParser\Node\Expr\MethodCall(new \PhpParser\Node\Expr\Variable(self::THIS), $classMethodName, $args);
        $return = new \PhpParser\Node\Stmt\Return_($methodCall);
        return new \PhpParser\Node\Expr\Closure(['params' => $classMethod->params, 'stmts' => [$return], 'returnType' => $classMethod->returnType]);
    }
    /**
     * @param string[] $names
     * @return Use_[]
     */
    public function createUsesFromNames(array $names) : array
    {
        $uses = [];
        foreach ($names as $name) {
            $useUse = new \PhpParser\Node\Stmt\UseUse(new \PhpParser\Node\Name($name));
            $uses[] = new \PhpParser\Node\Stmt\Use_([$useUse]);
        }
        return $uses;
    }
    /**
     * @param Node[] $args
     */
    public function createStaticCall(string $class, string $method, array $args = []) : \PhpParser\Node\Expr\StaticCall
    {
        //
        //        $args = $this->wrapToArg($args);
        //
        //        if (in_array($class, ['self', 'parent', 'static'], true)) {
        //            $class = new Name($class);
        //        } else {
        //            $class = new FullyQualified($class);
        //        }
        //
        //        return new StaticCall($class, $method, $args);
        $class = $this->createClassPart($class);
        $staticCall = new \PhpParser\Node\Expr\StaticCall($class, $method);
        $staticCall->args = $this->createArgs($args);
        return $staticCall;
    }
    /**
     * @param mixed[] $arguments
     */
    public function createFuncCall(string $name, array $arguments = []) : \PhpParser\Node\Expr\FuncCall
    {
        $arguments = $this->createArgs($arguments);
        return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name($name), $arguments);
    }
    public function createSelfFetchConstant(string $constantName, \PhpParser\Node $node) : \PhpParser\Node\Expr\ClassConstFetch
    {
        $name = new \PhpParser\Node\Name('self');
        $name->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME));
        return new \PhpParser\Node\Expr\ClassConstFetch($name, $constantName);
    }
    /**
     * @param Param[] $params
     * @return Arg[]
     */
    public function createArgsFromParams(array $params) : array
    {
        $args = [];
        foreach ($params as $param) {
            $args[] = new \PhpParser\Node\Arg($param->var);
        }
        return $args;
    }
    public function createNull() : \PhpParser\Node\Expr\ConstFetch
    {
        return new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name('null'));
    }
    public function createPromotedPropertyParam(\Rector\PostRector\ValueObject\PropertyMetadata $propertyMetadata) : \PhpParser\Node\Param
    {
        $paramBuilder = new \RectorPrefix20210408\Symplify\Astral\ValueObject\NodeBuilder\ParamBuilder($propertyMetadata->getName());
        $propertyType = $propertyMetadata->getType();
        if ($propertyType !== null) {
            $typeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($propertyType);
            if ($typeNode !== null) {
                $paramBuilder->setType($typeNode);
            }
        }
        $param = $paramBuilder->getNode();
        $propertyFlags = $propertyMetadata->getFlags();
        $param->flags = $propertyFlags !== 0 ? $propertyFlags : \PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE;
        return $param;
    }
    public function createFalse() : \PhpParser\Node\Expr\ConstFetch
    {
        return new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name('false'));
    }
    public function createTrue() : \PhpParser\Node\Expr\ConstFetch
    {
        return new \PhpParser\Node\Expr\ConstFetch(new \PhpParser\Node\Name('true'));
    }
    public function createClassConstFetchFromName(\PhpParser\Node\Name $className, string $constantName) : \PhpParser\Node\Expr\ClassConstFetch
    {
        $classConstFetch = $this->builderFactory->classConstFetch($className, $constantName);
        $classNameString = $className->toString();
        if (\in_array($classNameString, ['self', 'static'], \true)) {
            $currentNode = $this->currentNodeProvider->getNode();
            if ($currentNode !== null) {
                $className = $currentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
                $classConstFetch->class->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME, $className);
                $classConstFetch->class->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $className);
            }
        } else {
            $classConstFetch->class->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME, $classNameString);
        }
        return $classConstFetch;
    }
    /**
     * @param array<NotIdentical|BooleanAnd> $newNodes
     */
    public function createReturnBooleanAnd(array $newNodes) : ?\PhpParser\Node\Expr
    {
        if ($newNodes === []) {
            return null;
        }
        if (\count($newNodes) === 1) {
            return $newNodes[0];
        }
        return $this->createBooleanAndFromNodes($newNodes);
    }
    /**
     * @param mixed $item
     * @param string|int|null $key
     */
    private function createArrayItem($item, $key = null) : \PhpParser\Node\Expr\ArrayItem
    {
        $arrayItem = null;
        if ($item instanceof \PhpParser\Node\Expr\Variable || $item instanceof \PhpParser\Node\Expr\MethodCall || $item instanceof \PhpParser\Node\Expr\StaticCall || $item instanceof \PhpParser\Node\Expr\FuncCall || $item instanceof \PhpParser\Node\Expr\BinaryOp\Concat || $item instanceof \PhpParser\Node\Scalar || $item instanceof \PhpParser\Node\Expr\Cast) {
            $arrayItem = new \PhpParser\Node\Expr\ArrayItem($item);
        } elseif ($item instanceof \PhpParser\Node\Identifier) {
            $string = new \PhpParser\Node\Scalar\String_($item->toString());
            $arrayItem = new \PhpParser\Node\Expr\ArrayItem($string);
        } elseif (\is_scalar($item) || $item instanceof \PhpParser\Node\Expr\Array_) {
            $itemValue = \PhpParser\BuilderHelpers::normalizeValue($item);
            $arrayItem = new \PhpParser\Node\Expr\ArrayItem($itemValue);
        } elseif (\is_array($item)) {
            $arrayItem = new \PhpParser\Node\Expr\ArrayItem($this->createArray($item));
        }
        if ($item instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            $itemValue = \PhpParser\BuilderHelpers::normalizeValue($item);
            $arrayItem = new \PhpParser\Node\Expr\ArrayItem($itemValue);
        }
        if ($item instanceof \PhpParser\Node\Arg) {
            $arrayItem = new \PhpParser\Node\Expr\ArrayItem($item->value);
        }
        if ($arrayItem !== null) {
            $this->decoreateArrayItemWithKey($key, $arrayItem);
            return $arrayItem;
        }
        throw new \Rector\Core\Exception\NotImplementedYetException(\sprintf('Not implemented yet. Go to "%s()" and add check for "%s" node.', __METHOD__, \is_object($item) ? \get_class($item) : $item));
    }
    /**
     * @param mixed $value
     * @return mixed|Error|Variable
     */
    private function normalizeArgValue($value)
    {
        if ($value instanceof \PhpParser\Node\Param) {
            return $value->var;
        }
        return $value;
    }
    private function addPropertyType(\PhpParser\Node\Stmt\Property $property, ?\PHPStan\Type\Type $type) : void
    {
        if ($type === null) {
            return;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES)) {
            $phpParserType = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type);
            if ($phpParserType !== null) {
                $property->type = $phpParserType;
                if ($type instanceof \PHPStan\Type\Generic\GenericObjectType) {
                    $this->phpDocTypeChanger->changeVarType($phpDocInfo, $type);
                }
                return;
            }
        }
        $this->phpDocTypeChanger->changeVarType($phpDocInfo, $type);
    }
    /**
     * @param mixed $value
     */
    private function createClassConstant(string $name, $value, int $modifier) : \PhpParser\Node\Stmt\ClassConst
    {
        $value = \PhpParser\BuilderHelpers::normalizeValue($value);
        $const = new \PhpParser\Node\Const_($name, $value);
        $classConst = new \PhpParser\Node\Stmt\ClassConst([$const]);
        $classConst->flags |= $modifier;
        // add @var type by default
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($value);
        if (!$staticType instanceof \PHPStan\Type\MixedType) {
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classConst);
            $this->phpDocTypeChanger->changeVarType($phpDocInfo, $staticType);
        }
        return $classConst;
    }
    private function createClassPart(string $class) : \PhpParser\Node\Name
    {
        if (\in_array($class, self::REFERENCES, \true)) {
            return new \PhpParser\Node\Name($class);
        }
        return new \PhpParser\Node\Name\FullyQualified($class);
    }
    /**
     * @param int|string|null $key
     */
    private function decoreateArrayItemWithKey($key, \PhpParser\Node\Expr\ArrayItem $arrayItem) : void
    {
        if ($key !== null) {
            $arrayItem->key = \PhpParser\BuilderHelpers::normalizeValue($key);
        }
    }
    /**
     * @param NotIdentical[]|BooleanAnd[] $exprs
     */
    private function createBooleanAndFromNodes(array $exprs) : \PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        /** @var NotIdentical|BooleanAnd $booleanAnd */
        $booleanAnd = \array_shift($exprs);
        foreach ($exprs as $expr) {
            $booleanAnd = new \PhpParser\Node\Expr\BinaryOp\BooleanAnd($booleanAnd, $expr);
        }
        /** @var BooleanAnd $booleanAnd */
        return $booleanAnd;
    }
}
