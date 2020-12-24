<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector;

use _PhpScoperb75b35f52b74\Nette\Utils\Arrays;
use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Trait_;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeAnalyzer\ArrayCallableMethodReferenceAnalyzer;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\ValueObject\ArrayCallable;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
/**
 * @rector-doc
 * This service contains all the parsed nodes. E.g. all the functions, method call, classes, static calls etc.
 * It's useful in case of context analysis, e.g. find all the usage of class method to detect, if the method is used.
 */
final class NodeRepository
{
    /**
     * @var array<string, ClassMethod[]>
     */
    private $classMethodsByType = [];
    /**
     * @var array<string, Function_>
     */
    private $functionsByName = [];
    /**
     * @var array<string, FuncCall[]>
     */
    private $funcCallsByName = [];
    /**
     * @var array<string, array<array<MethodCall|StaticCall>>>
     */
    private $callsByTypeAndMethod = [];
    /**
     * E.g. [$this, 'someLocalMethod']
     * @var ArrayCallable[][][]
     */
    private $arrayCallablesByTypeAndMethod = [];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var ArrayCallableMethodReferenceAnalyzer
     */
    private $arrayCallableMethodReferenceAnalyzer;
    /**
     * @var ParsedPropertyFetchNodeCollector
     */
    private $parsedPropertyFetchNodeCollector;
    /**
     * @var ParsedClassConstFetchNodeCollector
     */
    private $parsedClassConstFetchNodeCollector;
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    /**
     * @var TypeUnwrapper
     */
    private $typeUnwrapper;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeAnalyzer\ArrayCallableMethodReferenceAnalyzer $arrayCallableMethodReferenceAnalyzer, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedPropertyFetchNodeCollector $parsedPropertyFetchNodeCollector, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedClassConstFetchNodeCollector $parsedClassConstFetchNodeCollector, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->arrayCallableMethodReferenceAnalyzer = $arrayCallableMethodReferenceAnalyzer;
        $this->parsedPropertyFetchNodeCollector = $parsedPropertyFetchNodeCollector;
        $this->parsedClassConstFetchNodeCollector = $parsedClassConstFetchNodeCollector;
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->typeUnwrapper = $typeUnwrapper;
    }
    /**
     * To prevent circular reference
     * @required
     */
    public function autowireNodeRepository(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function collect(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            $this->addMethod($node);
            return;
        }
        // array callable - [$this, 'someCall']
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
            $arrayCallable = $this->arrayCallableMethodReferenceAnalyzer->match($node);
            if ($arrayCallable === null) {
                return;
            }
            if (!$arrayCallable->isExistingMethod()) {
                return;
            }
            $this->arrayCallablesByTypeAndMethod[$arrayCallable->getClass()][$arrayCallable->getMethod()][] = $arrayCallable;
            return;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            $this->addCall($node);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_) {
            $functionName = $this->nodeNameResolver->getName($node);
            $this->functionsByName[$functionName] = $node;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            $functionName = $this->nodeNameResolver->getName($node);
            $this->funcCallsByName[$functionName][] = $node;
        }
    }
    public function findFunction(string $name) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_
    {
        return $this->functionsByName[$name] ?? null;
    }
    /**
     * @return MethodCall[][]|StaticCall[][]
     */
    public function findMethodCallsOnClass(string $className) : array
    {
        return $this->callsByTypeAndMethod[$className] ?? [];
    }
    /**
     * @return StaticCall[]
     */
    public function findStaticCallsByClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $calls = $this->findCallsByClassMethod($classMethod);
        return \array_filter($calls, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
            return $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
        });
    }
    /**
     * @return ClassMethod[]
     */
    public function findClassMethodByTypeAndMethod(string $desiredType, string $desiredMethodName) : array
    {
        $classMethods = [];
        foreach ($this->classMethodsByType as $className => $classMethodByMethodName) {
            if (!\is_a($className, $desiredType, \true)) {
                continue;
            }
            if (!isset($classMethodByMethodName[$desiredMethodName])) {
                continue;
            }
            $classMethods[] = $classMethodByMethodName[$desiredMethodName];
        }
        return $classMethods;
    }
    public function findClassMethodByStaticCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $method = $this->nodeNameResolver->getName($staticCall->name);
        if ($method === null) {
            return null;
        }
        $objectType = $this->nodeTypeResolver->resolve($staticCall->class);
        $classes = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getDirectClassNames($objectType);
        foreach ($classes as $class) {
            $possibleClassMethod = $this->findClassMethod($class, $method);
            if ($possibleClassMethod !== null) {
                return $possibleClassMethod;
            }
        }
        return null;
    }
    public function findClassMethod(string $className, string $methodName) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($methodName, '\\')) {
            $message = \sprintf('Class and method arguments are switched in "%s"', __METHOD__);
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException($message);
        }
        if (isset($this->classMethodsByType[$className][$methodName])) {
            return $this->classMethodsByType[$className][$methodName];
        }
        $parentClass = $className;
        if (!\class_exists($parentClass)) {
            return null;
        }
        while ($parentClass = \get_parent_class($parentClass)) {
            if (isset($this->classMethodsByType[$parentClass][$methodName])) {
                return $this->classMethodsByType[$parentClass][$methodName];
            }
        }
        return null;
    }
    public function isFunctionUsed(string $functionName) : bool
    {
        return isset($this->funcCallsByName[$functionName]);
    }
    /**
     * @return MethodCall[]
     */
    public function getMethodsCalls() : array
    {
        $calls = \_PhpScoperb75b35f52b74\Nette\Utils\Arrays::flatten($this->callsByTypeAndMethod);
        return \array_filter($calls, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
            return $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
        });
    }
    public function findClassMethodByMethodReflection(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $methodName = $methodReflection->getName();
        $classReflection = $methodReflection->getDeclaringClass();
        $className = $classReflection->getName();
        return $this->findClassMethod($className, $methodName);
    }
    /**
     * @return PropertyFetch[]
     */
    public function findPropertyFetchesByProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : array
    {
        /** @var string|null $className */
        $className = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return [];
        }
        /** @var string $propertyName */
        $propertyName = $this->nodeNameResolver->getName($property);
        return $this->parsedPropertyFetchNodeCollector->findPropertyFetchesByTypeAndName($className, $propertyName);
    }
    /**
     * @return PropertyFetch[]
     */
    public function findPropertyFetchesByPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : array
    {
        $propertyFetcheeType = $this->nodeTypeResolver->getStaticType($propertyFetch->var);
        if (!$propertyFetcheeType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return [];
        }
        if ($propertyFetcheeType instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
            $className = $propertyFetcheeType->getFullyQualifiedName();
        } else {
            $className = $propertyFetcheeType->getClassName();
        }
        /** @var string $propertyName */
        $propertyName = $this->nodeNameResolver->getName($propertyFetch);
        return $this->parsedPropertyFetchNodeCollector->findPropertyFetchesByTypeAndName($className, $propertyName);
    }
    /**
     * @return MethodCall[]|StaticCall[]|ArrayCallable[]
     */
    public function findCallsByClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $class = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\is_string($class)) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        /** @var string $method */
        $method = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        return $this->findCallsByClassAndMethod($class, $method);
    }
    /**
     * @return string[]
     */
    public function findDirectClassConstantFetches(string $desiredClassName, string $desiredConstantName) : array
    {
        $classConstantFetchByClassAndName = $this->parsedClassConstFetchNodeCollector->getClassConstantFetchByClassAndName();
        return $classConstantFetchByClassAndName[$desiredClassName][$desiredConstantName] ?? [];
    }
    /**
     * @return string[]
     */
    public function findIndirectClassConstantFetches(string $desiredClassName, string $desiredConstantName) : array
    {
        $classConstantFetchByClassAndName = $this->parsedClassConstFetchNodeCollector->getClassConstantFetchByClassAndName();
        foreach ($classConstantFetchByClassAndName as $className => $classesByConstantName) {
            if (!isset($classesByConstantName[$desiredConstantName])) {
                continue;
            }
            // include child usages
            if (!\is_a($desiredClassName, $className, \true)) {
                continue;
            }
            if ($desiredClassName === $className) {
                continue;
            }
            return $classesByConstantName[$desiredConstantName];
        }
        return [];
    }
    public function hasClassChildren(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $desiredClass) : bool
    {
        $desiredClassName = $desiredClass->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($desiredClassName === null) {
            return \false;
        }
        foreach ($this->parsedNodeCollector->getClasses() as $classNode) {
            $currentClassName = $classNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($currentClassName === null) {
                continue;
            }
            if (!$this->isChildOrEqualClassLike($desiredClassName, $currentClassName)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    /**
     * @return Class_[]
     */
    public function findClassesBySuffix(string $suffix) : array
    {
        $classNodes = [];
        foreach ($this->parsedNodeCollector->getClasses() as $className => $classNode) {
            if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($className, $suffix)) {
                continue;
            }
            $classNodes[] = $classNode;
        }
        return $classNodes;
    }
    /**
     * @return Trait_[]
     */
    public function findUsedTraitsInClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $traits = [];
        foreach ($classLike->getTraitUses() as $traitUse) {
            foreach ($traitUse->traits as $trait) {
                $traitName = $this->nodeNameResolver->getName($trait);
                $foundTrait = $this->parsedNodeCollector->findTrait($traitName);
                if ($foundTrait !== null) {
                    $traits[] = $foundTrait;
                }
            }
        }
        return $traits;
    }
    /**
     * @return Class_[]|Interface_[]
     */
    public function findClassesAndInterfacesByType(string $type) : array
    {
        return \array_merge($this->findChildrenOfClass($type), $this->findImplementersOfInterface($type));
    }
    /**
     * @return Class_[]
     */
    public function findChildrenOfClass(string $class) : array
    {
        $childrenClasses = [];
        foreach ($this->parsedNodeCollector->getClasses() as $classNode) {
            $currentClassName = $classNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if (!$this->isChildOrEqualClassLike($class, $currentClassName)) {
                continue;
            }
            $childrenClasses[] = $classNode;
        }
        return $childrenClasses;
    }
    public function findInterface(string $class) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_
    {
        return $this->parsedNodeCollector->findInterface($class);
    }
    public function findClass(string $name) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_
    {
        return $this->parsedNodeCollector->findClass($name);
    }
    public function findClassMethodByMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $className = $this->resolveCallerClassName($methodCall);
        if ($className === null) {
            return null;
        }
        $methodName = $this->nodeNameResolver->getName($methodCall->name);
        if ($methodName === null) {
            return null;
        }
        return $this->findClassMethod($className, $methodName);
    }
    public function findClassConstByClassConstFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch $classConstFetch) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassConst
    {
        return $this->parsedNodeCollector->findClassConstByClassConstFetch($classConstFetch);
    }
    private function addMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $className = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        // anonymous
        if ($className === null) {
            return;
        }
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $this->classMethodsByType[$className][$methodName] = $classMethod;
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function addCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        // one node can be of multiple-class types
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            $classType = $this->resolveNodeClassTypes($node->var);
        } else {
            /** @var StaticCall $node */
            $classType = $this->resolveNodeClassTypes($node->class);
        }
        // anonymous
        if ($classType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return;
        }
        $methodName = $this->nodeNameResolver->getName($node->name);
        if ($methodName === null) {
            return;
        }
        $this->addCallByType($node, $classType, $methodName);
    }
    /**
     * @return MethodCall[]|StaticCall[]|ArrayCallable[]
     */
    private function findCallsByClassAndMethod(string $className, string $methodName) : array
    {
        return $this->callsByTypeAndMethod[$className][$methodName] ?? $this->arrayCallablesByTypeAndMethod[$className][$methodName] ?? [];
    }
    private function isChildOrEqualClassLike(string $desiredClass, ?string $currentClassName) : bool
    {
        if ($currentClassName === null) {
            return \false;
        }
        if (!\is_a($currentClassName, $desiredClass, \true)) {
            return \false;
        }
        return $currentClassName !== $desiredClass;
    }
    /**
     * @return Interface_[]
     */
    private function findImplementersOfInterface(string $interface) : array
    {
        $implementerInterfaces = [];
        foreach ($this->parsedNodeCollector->getInterfaces() as $interfaceNode) {
            $className = $interfaceNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if (!$this->isChildOrEqualClassLike($interface, $className)) {
                continue;
            }
            $implementerInterfaces[] = $interfaceNode;
        }
        return $implementerInterfaces;
    }
    private function resolveCallerClassName(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?string
    {
        $callerType = $this->nodeTypeResolver->getStaticType($methodCall->var);
        $callerObjectType = $this->typeUnwrapper->unwrapFirstObjectTypeFromUnionType($callerType);
        if (!$callerObjectType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return null;
        }
        return $callerObjectType->getClassName();
    }
    private function resolveNodeClassTypes(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall && $node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable && $node->var->name === 'this') {
            /** @var string|null $className */
            $className = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($className) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($className);
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return $this->nodeTypeResolver->resolve($node->var);
        }
        return $this->nodeTypeResolver->resolve($node);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function addCallByType(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $classType, string $methodName) : void
    {
        if ($classType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            $this->callsByTypeAndMethod[$classType->getClassName()][$methodName][] = $node;
        }
        if ($classType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            foreach ($classType->getTypes() as $unionedType) {
                if (!$unionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
                    continue;
                }
                $this->callsByTypeAndMethod[$unionedType->getClassName()][$methodName][] = $node;
            }
        }
    }
}
