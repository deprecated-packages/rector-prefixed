<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection;

use Closure;
use Exception;
use InvalidArgumentException;
use LogicException;
use OutOfBoundsException;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Type;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param as ParamNode;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompileNodeToValue;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompilerContext;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\Uncloneable;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast\ReflectionParameterStringCast;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\FindParameterType;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\CalculateReflectionColum;
use RuntimeException;
use function assert;
use function count;
use function defined;
use function get_class;
use function in_array;
use function is_array;
use function is_object;
use function is_string;
use function ltrim;
use function sprintf;
use function strtolower;
class ReflectionParameter
{
    /** @var ParamNode */
    private $node;
    /** @var Namespace_|null */
    private $declaringNamespace;
    /** @var ReflectionFunctionAbstract */
    private $function;
    /** @var int */
    private $parameterIndex;
    /** @var scalar|array<scalar>|null */
    private $defaultValue;
    /** @var bool */
    private $isDefaultValueConstant = \false;
    /** @var string|null */
    private $defaultValueConstantName;
    /** @var Reflector */
    private $reflector;
    private function __construct()
    {
    }
    /**
     * Create a reflection of a parameter using a class name
     *
     * @throws OutOfBoundsException
     */
    public static function createFromClassNameAndMethod(string $className, string $methodName, string $parameterName) : self
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass::createFromName($className)->getMethod($methodName)->getParameter($parameterName);
    }
    /**
     * Create a reflection of a parameter using an instance
     *
     * @param object $instance
     *
     * @throws OutOfBoundsException
     */
    public static function createFromClassInstanceAndMethod($instance, string $methodName, string $parameterName) : self
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass::createFromInstance($instance)->getMethod($methodName)->getParameter($parameterName);
    }
    /**
     * Create a reflection of a parameter using a closure
     */
    public static function createFromClosure(\Closure $closure, string $parameterName) : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionParameter
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction::createFromClosure($closure)->getParameter($parameterName);
    }
    /**
     * Create the parameter from the given spec. Possible $spec parameters are:
     *
     *  - [$instance, 'method']
     *  - ['Foo', 'bar']
     *  - ['foo']
     *  - [function () {}]
     *
     * @param object[]|string[]|string|Closure $spec
     *
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public static function createFromSpec($spec, string $parameterName) : self
    {
        if (\is_array($spec) && \count($spec) === 2 && \is_string($spec[1])) {
            if (\is_object($spec[0])) {
                return self::createFromClassInstanceAndMethod($spec[0], $spec[1], $parameterName);
            }
            return self::createFromClassNameAndMethod($spec[0], $spec[1], $parameterName);
        }
        if (\is_string($spec)) {
            return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction::createFromName($spec)->getParameter($parameterName);
        }
        if ($spec instanceof \Closure) {
            return self::createFromClosure($spec, $parameterName);
        }
        throw new \InvalidArgumentException('Could not create reflection from the spec given');
    }
    public function __toString() : string
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast\ReflectionParameterStringCast::toString($this);
    }
    /**
     * @internal
     *
     * @param ParamNode       $node               Node has to be processed by the PhpParser\NodeVisitor\NameResolver
     * @param Namespace_|null $declaringNamespace namespace of the declaring function/method
     */
    public static function createFromNode(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $node, ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_ $declaringNamespace, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract $function, int $parameterIndex) : self
    {
        $param = new self();
        $param->reflector = $reflector;
        $param->node = $node;
        $param->declaringNamespace = $declaringNamespace;
        $param->function = $function;
        $param->parameterIndex = $parameterIndex;
        return $param;
    }
    private function parseDefaultValueNode() : void
    {
        if (!$this->isDefaultValueAvailable()) {
            throw new \LogicException('This parameter does not have a default value available');
        }
        $defaultValueNode = $this->node->default;
        if ($defaultValueNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch) {
            \assert($defaultValueNode->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name);
            $className = $defaultValueNode->class->toString();
            if ($className === 'self' || $className === 'static') {
                \assert($defaultValueNode->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier);
                $constantName = $defaultValueNode->name->name;
                $className = $this->findParentClassDeclaringConstant($constantName);
            }
            $this->isDefaultValueConstant = \true;
            \assert($defaultValueNode->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier);
            $this->defaultValueConstantName = $className . '::' . $defaultValueNode->name->name;
        }
        $namespace = null;
        if ($this->declaringNamespace !== null && $this->declaringNamespace->name !== null) {
            $namespace = (string) $this->declaringNamespace->name;
        }
        if ($defaultValueNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch && !\in_array(\strtolower($defaultValueNode->name->toString()), ['true', 'false', 'null'], \true)) {
            $this->isDefaultValueConstant = \true;
            if ($namespace !== null && !$defaultValueNode->name->isFullyQualified()) {
                $namespacedName = \sprintf('%s\\%s', $namespace, $defaultValueNode->name->toString());
                if (\defined($namespacedName)) {
                    $this->defaultValueConstantName = $namespacedName;
                } else {
                    try {
                        \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant::createFromName($namespacedName);
                        $this->defaultValueConstantName = $namespacedName;
                    } catch (\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                        // pass
                    }
                }
            }
            if ($this->defaultValueConstantName === null) {
                $this->defaultValueConstantName = $defaultValueNode->name->toString();
            }
        }
        $this->defaultValue = (new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompileNodeToValue())->__invoke($defaultValueNode, new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompilerContext($this->reflector, $this->function->getFileName(), $this->getDeclaringClass(), $namespace, $this->function->getName()));
    }
    /**
     * @throws LogicException
     */
    private function findParentClassDeclaringConstant(string $constantName) : string
    {
        $method = $this->function;
        \assert($method instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod);
        $class = $method->getDeclaringClass();
        do {
            if ($class->hasConstant($constantName)) {
                return $class->getName();
            }
            $class = $class->getParentClass();
        } while ($class);
        // note: this code is theoretically unreachable, so don't expect any coverage on it
        throw new \LogicException(\sprintf('Failed to find parent class of constant "%s".', $constantName));
    }
    /**
     * Get the name of the parameter.
     */
    public function getName() : string
    {
        \assert(\is_string($this->node->var->name));
        return $this->node->var->name;
    }
    /**
     * Get the function (or method) that declared this parameter.
     */
    public function getDeclaringFunction() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract
    {
        return $this->function;
    }
    /**
     * Get the class from the method that this parameter belongs to, if it
     * exists.
     *
     * This will return null if the declaring function is not a method.
     */
    public function getDeclaringClass() : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass
    {
        if ($this->function instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod) {
            return $this->function->getDeclaringClass();
        }
        return null;
    }
    /**
     * Is the parameter optional?
     *
     * Note this is distinct from "isDefaultValueAvailable" because you can have
     * a default value, but the parameter not be optional. In the example, the
     * $foo parameter isOptional() == false, but isDefaultValueAvailable == true
     *
     * @example someMethod($foo = 'foo', $bar)
     */
    public function isOptional() : bool
    {
        return (bool) $this->node->isOptional || $this->isVariadic();
    }
    /**
     * Does the parameter have a default, regardless of whether it is optional.
     *
     * Note this is distinct from "isOptional" because you can have
     * a default value, but the parameter not be optional. In the example, the
     * $foo parameter isOptional() == false, but isDefaultValueAvailable == true
     *
     * @example someMethod($foo = 'foo', $bar)
     */
    public function isDefaultValueAvailable() : bool
    {
        return $this->node->default !== null;
    }
    /**
     * Get the default value of the parameter.
     *
     * @return scalar|array<scalar>|null
     *
     * @throws LogicException
     */
    public function getDefaultValue()
    {
        $this->parseDefaultValueNode();
        return $this->defaultValue;
    }
    /**
     * Does this method allow null for a parameter?
     */
    public function allowsNull() : bool
    {
        if (!$this->hasType()) {
            return \true;
        }
        if ($this->node->type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType) {
            return \true;
        }
        if (!$this->isDefaultValueAvailable()) {
            return \false;
        }
        return $this->getDefaultValue() === null;
    }
    /**
     * Get the DocBlock type hints as an array of strings.
     *
     * @return string[]
     */
    public function getDocBlockTypeStrings() : array
    {
        $stringTypes = [];
        foreach ($this->getDocBlockTypes() as $type) {
            $stringTypes[] = (string) $type;
        }
        return $stringTypes;
    }
    /**
     * Get the types defined in the DocBlocks. This returns an array because
     * the parameter may have multiple (compound) types specified (for example
     * when you type hint pipe-separated "string|null", in which case this
     * would return an array of Type objects, one for string, one for null.
     *
     * @see getTypeHint()
     *
     * @return Type[]
     */
    public function getDocBlockTypes() : array
    {
        return (new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\FindParameterType())->__invoke($this->function, $this->declaringNamespace, $this->node);
    }
    /**
     * Find the position of the parameter, left to right, starting at zero.
     */
    public function getPosition() : int
    {
        return $this->parameterIndex;
    }
    /**
     * Get the ReflectionType instance representing the type declaration for
     * this parameter
     *
     * (note: this has nothing to do with DocBlocks).
     */
    public function getType() : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionType
    {
        $type = $this->node->type;
        if ($type === null) {
            return null;
        }
        if (!$type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType && $this->allowsNull()) {
            $type = new \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType($type);
        }
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionType::createFromTypeAndReflector($type);
    }
    /**
     * Does this parameter have a type declaration?
     *
     * (note: this has nothing to do with DocBlocks).
     */
    public function hasType() : bool
    {
        return $this->node->type !== null;
    }
    /**
     * Set the parameter type declaration.
     */
    public function setType(string $newParameterType) : void
    {
        $this->node->type = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($newParameterType);
    }
    /**
     * Remove the parameter type declaration completely.
     */
    public function removeType() : void
    {
        $this->node->type = null;
    }
    /**
     * Is this parameter an array?
     */
    public function isArray() : bool
    {
        $type = \ltrim((string) $this->getType(), '?');
        return \strtolower($type) === 'array';
    }
    /**
     * Is this parameter a callable?
     */
    public function isCallable() : bool
    {
        $type = \ltrim((string) $this->getType(), '?');
        return \strtolower($type) === 'callable';
    }
    /**
     * Is this parameter a variadic (denoted by ...$param).
     */
    public function isVariadic() : bool
    {
        return $this->node->variadic;
    }
    /**
     * Is this parameter passed by reference (denoted by &$param).
     */
    public function isPassedByReference() : bool
    {
        return $this->node->byRef;
    }
    public function canBePassedByValue() : bool
    {
        return !$this->isPassedByReference();
    }
    public function isDefaultValueConstant() : bool
    {
        $this->parseDefaultValueNode();
        return $this->isDefaultValueConstant;
    }
    public function isPromoted() : bool
    {
        return $this->node->flags !== 0;
    }
    /**
     * @throws LogicException
     */
    public function getDefaultValueConstantName() : string
    {
        $this->parseDefaultValueNode();
        if (!$this->isDefaultValueConstant()) {
            throw new \LogicException('This parameter is not a constant default value, so cannot have a constant name');
        }
        return $this->defaultValueConstantName;
    }
    /**
     * Gets a ReflectionClass for the type hint (returns null if not a class)
     *
     * @throws RuntimeException
     */
    public function getClass() : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass
    {
        $className = $this->getClassName();
        if ($className === null) {
            return null;
        }
        if (!$this->reflector instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector) {
            throw new \RuntimeException(\sprintf('Unable to reflect class type because we were not given a "%s", but a "%s" instead', \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector::class, \get_class($this->reflector)));
        }
        return $this->reflector->reflect($className);
    }
    private function getClassName() : ?string
    {
        if (!$this->hasType()) {
            return null;
        }
        $type = $this->getType();
        if (!$type instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionNamedType) {
            return null;
        }
        $typeHint = $type->getName();
        if ($typeHint === 'self') {
            $declaringClass = $this->getDeclaringClass();
            \assert($declaringClass instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass);
            return $declaringClass->getName();
        }
        if ($typeHint === 'parent') {
            $declaringClass = $this->getDeclaringClass();
            \assert($declaringClass instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass);
            $parentClass = $declaringClass->getParentClass();
            \assert($parentClass instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass);
            return $parentClass->getName();
        }
        if ($type->isBuiltin()) {
            return null;
        }
        return $typeHint;
    }
    /**
     * {@inheritdoc}
     *
     * @throws Uncloneable
     */
    public function __clone()
    {
        throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\Uncloneable::fromClass(self::class);
    }
    public function getStartColumn() : int
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\CalculateReflectionColum::getStartColumn($this->function->getLocatedSource()->getSource(), $this->node);
    }
    public function getEndColumn() : int
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\CalculateReflectionColum::getEndColumn($this->function->getLocatedSource()->getSource(), $this->node);
    }
    public function getAst() : \_PhpScoperb75b35f52b74\PhpParser\Node\Param
    {
        return $this->node;
    }
}