<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber;

use LogicException;
use PhpParser\Builder;
use PhpParser\Builder\Class_;
use PhpParser\Builder\Declaration;
use PhpParser\Builder\Function_;
use PhpParser\Builder\FunctionLike;
use PhpParser\Builder\Interface_;
use PhpParser\Builder\Method;
use PhpParser\Builder\Param;
use PhpParser\Builder\Property;
use PhpParser\Builder\Trait_;
use PhpParser\BuilderFactory;
use PhpParser\BuilderHelpers;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Const_;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\Class_ as ClassNode;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\TraitUse;
use PhpParser\Node\Stmt\TraitUseAdaptation;
use PhpParser\NodeAbstract;
use PhpParser\PrettyPrinter\Standard;
use ReflectionClass as CoreReflectionClass;
use ReflectionClassConstant;
use ReflectionFunction as CoreReflectionFunction;
use ReflectionFunctionAbstract as CoreReflectionFunctionAbstract;
use ReflectionMethod as CoreReflectionMethod;
use ReflectionNamedType as CoreReflectionNamedType;
use ReflectionParameter;
use ReflectionProperty as CoreReflectionProperty;
use _HumbugBox221ad6f1b81f\ReflectionUnionType as CoreReflectionUnionType;
use Reflector as CoreReflector;
use function array_diff;
use function array_key_exists;
use function assert;
use function class_exists;
use function explode;
use function function_exists;
use function get_defined_constants;
use function in_array;
use function interface_exists;
use function method_exists;
use function strtolower;
use function trait_exists;
/**
 * It generates a stub source from internal reflection for given class or function name.
 *
 * @internal
 */
final class ReflectionSourceStubber implements \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber
{
    private const BUILDER_OPTIONS = ['shortArraySyntax' => \true];
    /** @var BuilderFactory */
    private $builderFactory;
    /** @var Standard */
    private $prettyPrinter;
    public function __construct()
    {
        $this->builderFactory = new \PhpParser\BuilderFactory();
        $this->prettyPrinter = new \PhpParser\PrettyPrinter\Standard(self::BUILDER_OPTIONS);
    }
    public function hasClass(string $className) : bool
    {
        return \class_exists($className, \false) || \interface_exists($className, \false) || \trait_exists($className, \false);
    }
    public function generateClassStub(string $className) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        if (!$this->hasClass($className)) {
            return null;
        }
        $classReflection = new \ReflectionClass($className);
        $classNode = $this->createClass($classReflection);
        if ($classNode instanceof \PhpParser\Builder\Class_) {
            $this->addClassModifiers($classNode, $classReflection);
        }
        if ($classNode instanceof \PhpParser\Builder\Class_ || $classNode instanceof \PhpParser\Builder\Interface_) {
            $this->addExtendsAndImplements($classNode, $classReflection);
        }
        if ($classNode instanceof \PhpParser\Builder\Class_ || $classNode instanceof \PhpParser\Builder\Trait_) {
            $this->addProperties($classNode, $classReflection);
            $this->addTraitUse($classNode, $classReflection);
        }
        $this->addDocComment($classNode, $classReflection);
        $this->addConstants($classNode, $classReflection);
        $this->addMethods($classNode, $classReflection);
        $extensionName = $classReflection->getExtensionName() ?: null;
        if (!$classReflection->inNamespace()) {
            return $this->createStubData($this->generateStub($classNode->getNode()), $extensionName);
        }
        return $this->createStubData($this->generateStubInNamespace($classNode->getNode(), $classReflection->getNamespaceName()), $extensionName);
    }
    public function generateFunctionStub(string $functionName) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        if (!\function_exists($functionName)) {
            return null;
        }
        $functionReflection = new \ReflectionFunction($functionName);
        $functionNode = $this->builderFactory->function($functionReflection->getShortName());
        $this->addDocComment($functionNode, $functionReflection);
        $this->addParameters($functionNode, $functionReflection);
        $returnType = $functionReflection->getReturnType();
        \assert($returnType instanceof \ReflectionNamedType || $returnType instanceof \_HumbugBox221ad6f1b81f\ReflectionUnionType || $returnType === null);
        if ($returnType !== null) {
            $functionNode->setReturnType($this->formatType($returnType));
        }
        $extensionName = $functionReflection->getExtensionName() ?: null;
        if (!$functionReflection->inNamespace()) {
            return $this->createStubData($this->generateStub($functionNode->getNode()), $extensionName);
        }
        return $this->createStubData($this->generateStubInNamespace($functionNode->getNode(), $functionReflection->getNamespaceName()), $extensionName);
    }
    public function generateConstantStub(string $constantName) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        // Not supported because of resource as value
        if (\in_array($constantName, ['STDIN', 'STDOUT', 'STDERR'], \true)) {
            return null;
        }
        $constantData = $this->findConstantData($constantName);
        if ($constantData === null) {
            return null;
        }
        [$constantValue, $extensionName] = $constantData;
        $constantNode = $this->builderFactory->funcCall('define', [$constantName, $constantValue]);
        return $this->createStubData($this->generateStub($constantNode), $extensionName);
    }
    /**
     * @return array{0: scalar|scalar[]|null, 1: string}|null
     */
    private function findConstantData(string $constantName) : ?array
    {
        /** @var array<string, array<string, int|string|float|bool|array|resource|null>> $constants */
        $constants = \get_defined_constants(\true);
        foreach ($constants as $constantExtensionName => $extensionConstants) {
            if (\array_key_exists($constantName, $extensionConstants)) {
                return [$extensionConstants[$constantName], $constantExtensionName !== 'user' ? $constantExtensionName : null];
            }
        }
        return null;
    }
    /**
     * @return Class_|Interface_|Trait_
     */
    private function createClass(\ReflectionClass $classReflection) : \PhpParser\Builder\Declaration
    {
        if ($classReflection->isTrait()) {
            return $this->builderFactory->trait($classReflection->getShortName());
        }
        if ($classReflection->isInterface()) {
            return $this->builderFactory->interface($classReflection->getShortName());
        }
        return $this->builderFactory->class($classReflection->getShortName());
    }
    /**
     * @param Class_|Interface_|Trait_|Method|Property|Function_                                     $node
     * @param CoreReflectionClass|CoreReflectionMethod|CoreReflectionProperty|CoreReflectionFunction $reflection
     */
    private function addDocComment(\PhpParser\Builder $node, \Reflector $reflection) : void
    {
        if ($reflection->getDocComment() === \false) {
            return;
        }
        $node->setDocComment(new \PhpParser\Comment\Doc($reflection->getDocComment()));
    }
    private function addClassModifiers(\PhpParser\Builder\Class_ $classNode, \ReflectionClass $classReflection) : void
    {
        if (!$classReflection->isInterface() && $classReflection->isAbstract()) {
            // Interface \Iterator is interface and abstract
            $classNode->makeAbstract();
        }
        if (!$classReflection->isFinal()) {
            return;
        }
        $classNode->makeFinal();
    }
    /**
     * @param Class_|Interface_ $classNode
     */
    private function addExtendsAndImplements(\PhpParser\Builder\Declaration $classNode, \ReflectionClass $classReflection) : void
    {
        $parentClass = $classReflection->getParentClass();
        $interfaces = $classReflection->getInterfaceNames();
        if ($parentClass) {
            $classNode->extend(new \PhpParser\Node\Name\FullyQualified($parentClass->getName()));
            $interfaces = \array_diff($interfaces, $parentClass->getInterfaceNames());
        }
        foreach ($classReflection->getInterfaces() as $interface) {
            $interfaces = \array_diff($interfaces, $interface->getInterfaceNames());
        }
        foreach ($interfaces as $interfaceName) {
            if ($classNode instanceof \PhpParser\Builder\Interface_) {
                $classNode->extend(new \PhpParser\Node\Name\FullyQualified($interfaceName));
            } else {
                $classNode->implement(new \PhpParser\Node\Name\FullyQualified($interfaceName));
            }
        }
    }
    private function addTraitUse(\PhpParser\Builder\Declaration $classNode, \ReflectionClass $classReflection) : void
    {
        $alreadyUsedTraitNames = [];
        foreach ($classReflection->getTraitAliases() as $methodNameAlias => $methodInfo) {
            [$traitName, $methodName] = \explode('::', $methodInfo);
            $traitUseNode = new \PhpParser\Node\Stmt\TraitUse([new \PhpParser\Node\Name\FullyQualified($traitName)], [new \PhpParser\Node\Stmt\TraitUseAdaptation\Alias(new \PhpParser\Node\Name\FullyQualified($traitName), $methodName, null, $methodNameAlias)]);
            $classNode->addStmt($traitUseNode);
            $alreadyUsedTraitNames[] = $traitName;
        }
        foreach (\array_diff($classReflection->getTraitNames(), $alreadyUsedTraitNames) as $traitName) {
            $classNode->addStmt(new \PhpParser\Node\Stmt\TraitUse([new \PhpParser\Node\Name\FullyQualified($traitName)]));
        }
    }
    private function addProperties(\PhpParser\Builder\Declaration $classNode, \ReflectionClass $classReflection) : void
    {
        $defaultProperties = $classReflection->getDefaultProperties();
        foreach ($classReflection->getProperties() as $propertyReflection) {
            if (!$this->isPropertyDeclaredInClass($propertyReflection, $classReflection)) {
                continue;
            }
            $propertyNode = $this->builderFactory->property($propertyReflection->getName());
            $this->addPropertyModifiers($propertyNode, $propertyReflection);
            $this->addDocComment($propertyNode, $propertyReflection);
            if (\array_key_exists($propertyReflection->getName(), $defaultProperties)) {
                try {
                    $propertyNode->setDefault($defaultProperties[$propertyReflection->getName()]);
                } catch (\LogicException $e) {
                    // Unsupported value
                }
            }
            if (\method_exists($propertyReflection, 'getType')) {
                $propertyType = $propertyReflection->getType();
                \assert($propertyType instanceof \ReflectionNamedType || $propertyType instanceof \_HumbugBox221ad6f1b81f\ReflectionUnionType || $propertyType === null);
                if ($propertyType !== null) {
                    $propertyNode->setType($this->formatType($propertyType));
                }
            }
            $classNode->addStmt($propertyNode);
        }
    }
    private function isPropertyDeclaredInClass(\ReflectionProperty $propertyReflection, \ReflectionClass $classReflection) : bool
    {
        if ($propertyReflection->getDeclaringClass()->getName() !== $classReflection->getName()) {
            return \false;
        }
        foreach ($classReflection->getTraits() as $trait) {
            if ($trait->hasProperty($propertyReflection->getName())) {
                return \false;
            }
        }
        return \true;
    }
    private function addPropertyModifiers(\PhpParser\Builder\Property $propertyNode, \ReflectionProperty $propertyReflection) : void
    {
        if ($propertyReflection->isStatic()) {
            $propertyNode->makeStatic();
        }
        if ($propertyReflection->isPublic()) {
            $propertyNode->makePublic();
        }
        if ($propertyReflection->isProtected()) {
            $propertyNode->makeProtected();
        }
        if (!$propertyReflection->isPrivate()) {
            return;
        }
        $propertyNode->makePrivate();
    }
    private function addConstants(\PhpParser\Builder\Declaration $classNode, \ReflectionClass $classReflection) : void
    {
        foreach ($classReflection->getReflectionConstants() as $constantReflection) {
            if ($constantReflection->getDeclaringClass()->getName() !== $classReflection->getName()) {
                continue;
            }
            $classConstantNode = new \PhpParser\Node\Stmt\ClassConst([new \PhpParser\Node\Const_($constantReflection->getName(), \PhpParser\BuilderHelpers::normalizeValue($constantReflection->getValue()))], $this->constantVisibilityFlags($constantReflection));
            if ($constantReflection->getDocComment() !== \false) {
                $classConstantNode->setDocComment(new \PhpParser\Comment\Doc($constantReflection->getDocComment()));
            }
            $classNode->addStmt($classConstantNode);
        }
    }
    private function constantVisibilityFlags(\ReflectionClassConstant $constant) : int
    {
        if ($constant->isPrivate()) {
            return \PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE;
        }
        if ($constant->isProtected()) {
            return \PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED;
        }
        return \PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC;
    }
    private function addMethods(\PhpParser\Builder\Declaration $classNode, \ReflectionClass $classReflection) : void
    {
        foreach ($classReflection->getMethods() as $methodReflection) {
            if (!$this->isMethodDeclaredInClass($methodReflection, $classReflection)) {
                continue;
            }
            $methodNode = $this->builderFactory->method($methodReflection->getName());
            $this->addMethodFlags($methodNode, $methodReflection);
            $this->addDocComment($methodNode, $methodReflection);
            $this->addParameters($methodNode, $methodReflection);
            $returnType = $methodReflection->getReturnType();
            \assert($returnType instanceof \ReflectionNamedType || $returnType instanceof \_HumbugBox221ad6f1b81f\ReflectionUnionType || $returnType === null);
            if ($methodReflection->getReturnType() !== null) {
                $methodNode->setReturnType($this->formatType($returnType));
            }
            $classNode->addStmt($methodNode);
        }
    }
    private function isMethodDeclaredInClass(\ReflectionMethod $methodReflection, \ReflectionClass $classReflection) : bool
    {
        if ($methodReflection->getDeclaringClass()->getName() !== $classReflection->getName()) {
            return \false;
        }
        if (\array_key_exists($methodReflection->getName(), $classReflection->getTraitAliases())) {
            return \false;
        }
        foreach ($classReflection->getTraits() as $trait) {
            if ($trait->hasMethod($methodReflection->getName())) {
                return \false;
            }
        }
        return \true;
    }
    private function addMethodFlags(\PhpParser\Builder\Method $methodNode, \ReflectionMethod $methodReflection) : void
    {
        if ($methodReflection->isFinal()) {
            $methodNode->makeFinal();
        }
        if ($methodReflection->isAbstract() && !$methodReflection->getDeclaringClass()->isInterface()) {
            $methodNode->makeAbstract();
        }
        if ($methodReflection->isStatic()) {
            $methodNode->makeStatic();
        }
        if ($methodReflection->isPublic()) {
            $methodNode->makePublic();
        }
        if ($methodReflection->isProtected()) {
            $methodNode->makeProtected();
        }
        if ($methodReflection->isPrivate()) {
            $methodNode->makePrivate();
        }
        if (!$methodReflection->returnsReference()) {
            return;
        }
        $methodNode->makeReturnByRef();
    }
    private function addParameters(\PhpParser\Builder\FunctionLike $functionNode, \ReflectionFunctionAbstract $functionReflectionAbstract) : void
    {
        foreach ($functionReflectionAbstract->getParameters() as $parameterReflection) {
            $parameterNode = $this->builderFactory->param($parameterReflection->getName());
            $this->addParameterModifiers($parameterReflection, $parameterNode);
            if ($parameterReflection->isOptional() && !$parameterReflection->isVariadic()) {
                if ($parameterReflection->isDefaultValueAvailable()) {
                    $parameterNode->setDefault($this->parameterDefaultValue($parameterReflection, $functionReflectionAbstract));
                } else {
                    $parameterNode->setDefault(null);
                }
            }
            $functionNode->addParam($this->addParameterModifiers($parameterReflection, $parameterNode));
        }
    }
    private function addParameterModifiers(\ReflectionParameter $parameterReflection, \PhpParser\Builder\Param $parameterNode) : \PhpParser\Builder\Param
    {
        if ($parameterReflection->isVariadic()) {
            $parameterNode->makeVariadic();
        }
        if ($parameterReflection->isPassedByReference()) {
            $parameterNode->makeByRef();
        }
        $parameterType = $parameterReflection->getType();
        \assert($parameterType instanceof \ReflectionNamedType || $parameterType instanceof \_HumbugBox221ad6f1b81f\ReflectionUnionType || $parameterType === null);
        if ($parameterReflection->getType() !== null) {
            $parameterNode->setType($this->formatType($parameterType));
        }
        return $parameterNode;
    }
    /**
     * @return mixed
     */
    private function parameterDefaultValue(\ReflectionParameter $parameterReflection, \ReflectionFunctionAbstract $functionReflectionAbstract)
    {
        if ($functionReflectionAbstract->isInternal()) {
            return null;
        }
        return $parameterReflection->getDefaultValue();
    }
    /**
     * @param CoreReflectionNamedType|CoreReflectionUnionType $type
     *
     * @return Name|FullyQualified|NullableType|Node\UnionType
     */
    private function formatType($type) : \PhpParser\NodeAbstract
    {
        if ($type instanceof \_HumbugBox221ad6f1b81f\ReflectionUnionType) {
            $innerTypes = [];
            $addNull = $type->allowsNull();
            $hasNull = \false;
            foreach ($type->getTypes() as $innerType) {
                \assert($innerType instanceof \ReflectionNamedType);
                if (\strtolower($innerType->getName()) === 'null') {
                    $hasNull = \true;
                }
                $formattedType = $this->formatType($innerType);
                if ($formattedType instanceof \PhpParser\Node\NullableType) {
                    $addNull = \true;
                    $formattedType = $formattedType->type;
                }
                $innerTypes[] = $formattedType;
            }
            if ($addNull && !$hasNull) {
                $innerTypes[] = new \PhpParser\Node\Name('null');
            }
            return new \PhpParser\Node\UnionType($innerTypes);
        }
        $name = $type->getName();
        $nameNode = $type->isBuiltin() || \in_array($name, ['self', 'parent'], \true) ? new \PhpParser\Node\Name($name) : new \PhpParser\Node\Name\FullyQualified($name);
        return $type->allowsNull() ? new \PhpParser\Node\NullableType($nameNode) : $nameNode;
    }
    private function generateStubInNamespace(\PhpParser\Node $node, string $namespaceName) : string
    {
        $namespaceBuilder = $this->builderFactory->namespace($namespaceName);
        $namespaceBuilder->addStmt($node);
        return $this->generateStub($namespaceBuilder->getNode());
    }
    private function generateStub(\PhpParser\Node $node) : string
    {
        return "<?php\n\n" . $this->prettyPrinter->prettyPrint([$node]) . ($node instanceof \PhpParser\Node\Expr\FuncCall ? ';' : '') . "\n";
    }
    private function createStubData(string $stub, ?string $extensionName) : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        return new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData($stub, $extensionName);
    }
}
