<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection;

use LogicException;
use OutOfBoundsException;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_ as ClassNode;
use PhpParser\Node\Stmt\ClassConst as ConstNode;
use PhpParser\Node\Stmt\ClassLike as ClassLikeNode;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Interface_ as InterfaceNode;
use PhpParser\Node\Stmt\Namespace_ as NamespaceNode;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Property as PropertyNode;
use PhpParser\Node\Stmt\Trait_ as TraitNode;
use PhpParser\Node\Stmt\TraitUse;
use ReflectionClass as CoreReflectionClass;
use ReflectionException;
use ReflectionProperty as CoreReflectionProperty;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\BetterReflection;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompileNodeToValue;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompilerContext;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\ClassDoesNotExist;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NoObjectProvided;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnObject;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\ObjectNotInstanceOfClass;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\PropertyDoesNotExist;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\Uncloneable;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast\ReflectionClassStringCast;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\CalculateReflectionColum;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\GetLastDocComment;
use Traversable;
use function array_combine;
use function array_filter;
use function array_key_exists;
use function array_map;
use function array_merge;
use function array_reverse;
use function array_slice;
use function array_values;
use function assert;
use function implode;
use function in_array;
use function is_object;
use function is_string;
use function ltrim;
use function sha1;
use function sprintf;
use function strtolower;
class ReflectionClass implements \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
{
    public const ANONYMOUS_CLASS_NAME_PREFIX = 'class@anonymous';
    /** @var Reflector */
    private $reflector;
    /** @var NamespaceNode|null */
    private $declaringNamespace;
    /** @var LocatedSource */
    private $locatedSource;
    /** @var ClassLikeNode */
    private $node;
    /** @var array<string, ReflectionClassConstant>|null indexed by name, when present */
    private $cachedReflectionConstants;
    /** @var array<string, ReflectionProperty>|null */
    private $cachedImmediateProperties;
    /** @var array<string, ReflectionProperty>|null */
    private $cachedProperties;
    /** @var array<lowercase-string, ReflectionMethod>|null */
    private $cachedMethods;
    /** @var array<string, string>|null */
    private $cachedTraitAliases;
    /** @var array<string, string>|null */
    private $cachedTraitPrecedences;
    /** @var self|null */
    private $cachedParentClass;
    /** @var self[]|null */
    private $cachedInheritanceClassHierarchy;
    /** @var string|null */
    private $cachedName;
    private function __construct()
    {
    }
    public function __toString() : string
    {
        return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\StringCast\ReflectionClassStringCast::toString($this);
    }
    /**
     * Create a ReflectionClass by name, using default reflectors etc.
     *
     * @throws IdentifierNotFound
     */
    public static function createFromName(string $className) : self
    {
        return (new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\BetterReflection())->classReflector()->reflect($className);
    }
    /**
     * Create a ReflectionClass from an instance, using default reflectors etc.
     *
     * This is simply a helper method that calls ReflectionObject::createFromInstance().
     *
     * @see ReflectionObject::createFromInstance
     *
     * @param object $instance
     *
     * @throws IdentifierNotFound
     * @throws ReflectionException
     */
    public static function createFromInstance($instance) : self
    {
        return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionObject::createFromInstance($instance);
    }
    /**
     * Create from a Class Node.
     *
     * @internal
     *
     * @param ClassLikeNode      $node      Node has to be processed by the PhpParser\NodeVisitor\NameResolver
     * @param NamespaceNode|null $namespace optional - if omitted, we assume it is global namespaced class
     */
    public static function createFromNode(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \PhpParser\Node\Stmt\ClassLike $node, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, ?\PhpParser\Node\Stmt\Namespace_ $namespace = null) : self
    {
        $class = new self();
        $class->reflector = $reflector;
        $class->locatedSource = $locatedSource;
        $class->node = $node;
        $class->declaringNamespace = $namespace;
        return $class;
    }
    /**
     * Get the "short" name of the class (e.g. for A\B\Foo, this will return
     * "Foo").
     */
    public function getShortName() : string
    {
        if (!$this->isAnonymous()) {
            \assert($this->node->name instanceof \PhpParser\Node\Identifier);
            return $this->node->name->name;
        }
        $fileName = $this->getFileName();
        if ($fileName === null) {
            $fileName = \sha1($this->locatedSource->getSource());
        }
        return \sprintf('%s%c%s(%d)', self::ANONYMOUS_CLASS_NAME_PREFIX, "\0", $fileName, $this->getStartLine());
    }
    /**
     * Get the "full" name of the class (e.g. for A\B\Foo, this will return
     * "A\B\Foo").
     *
     * @return class-string
     */
    public function getName() : string
    {
        if ($this->cachedName === null) {
            if (!$this->inNamespace()) {
                $this->cachedName = $this->getShortName();
            } else {
                $this->cachedName = $this->node->namespacedName->toString();
            }
        }
        return $this->cachedName;
    }
    /**
     * Get the "namespace" name of the class (e.g. for A\B\Foo, this will
     * return "A\B").
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     */
    public function getNamespaceName() : string
    {
        if (!$this->inNamespace()) {
            return '';
        }
        return \implode('\\', $this->declaringNamespace->name->parts);
    }
    /**
     * Decide if this class is part of a namespace. Returns false if the class
     * is in the global namespace or does not have a specified namespace.
     */
    public function inNamespace() : bool
    {
        return $this->declaringNamespace !== null && $this->declaringNamespace->name !== null;
    }
    public function getExtensionName() : ?string
    {
        return $this->locatedSource->getExtensionName();
    }
    /**
     * @return ReflectionMethod[]
     */
    private function createMethodsFromTrait(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod $method) : array
    {
        $traitAliases = $this->getTraitAliases();
        $traitPrecedences = $this->getTraitPrecedences();
        $methodAst = $method->getAst();
        \assert($methodAst instanceof \PhpParser\Node\Stmt\ClassMethod);
        $methodHash = $this->methodHash($method->getImplementingClass()->getName(), $method->getName());
        $createMethod = function (?string $aliasMethodName) use($method, $methodAst) : ReflectionMethod {
            return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod::createFromNode($this->reflector, $methodAst, $method->getDeclaringClass()->getDeclaringNamespaceAst(), $method->getDeclaringClass(), $this, $aliasMethodName);
        };
        $methods = [];
        foreach ($traitAliases as $aliasMethodName => $traitAliasDefinition) {
            if ($methodHash !== $traitAliasDefinition) {
                continue;
            }
            $methods[] = $createMethod($aliasMethodName);
        }
        if (!\array_key_exists($methodHash, $traitPrecedences)) {
            $methods[] = $createMethod($method->getAliasName());
        }
        return $methods;
    }
    /**
     * @return list<ReflectionMethod>
     */
    private function getParentMethods() : array
    {
        return \array_merge([], ...\array_map(static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $ancestor) : array {
            return $ancestor->getMethods();
        }, \array_filter([$this->getParentClass()])));
    }
    /**
     * @return list<ReflectionMethod>
     */
    private function getMethodsFromTraits() : array
    {
        return \array_merge([], ...\array_map(function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $trait) : array {
            return \array_merge([], ...\array_map(function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod $method) : array {
                return $this->createMethodsFromTrait($method);
            }, $trait->getMethods()));
        }, $this->getTraits()));
    }
    /**
     * @return list<ReflectionMethod>
     */
    private function getMethodsFromInterfaces() : array
    {
        return \array_merge([], ...\array_map(static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $ancestor) : array {
            return $ancestor->getMethods();
        }, \array_values($this->getInterfaces())));
    }
    /**
     * Construct a flat list of all methods in this precise order from:
     *  - current class
     *  - parent class
     *  - traits used in parent class
     *  - interfaces implemented in parent class
     *  - traits used in current class
     *  - interfaces implemented in current class
     *
     * Methods are not merged via their name as array index, since internal PHP method
     * sorting does not follow `\array_merge()` semantics.
     *
     * @return array<lowercase-string, ReflectionMethod> indexed by method name
     */
    private function getMethodsIndexedByName() : array
    {
        if ($this->cachedMethods !== null) {
            return $this->cachedMethods;
        }
        $classMethods = $this->getImmediateMethods();
        $parentMethods = $this->getParentMethods();
        $traitsMethods = $this->getMethodsFromTraits();
        $interfaceMethods = $this->getMethodsFromInterfaces();
        $methods = [];
        foreach ([$classMethods, $parentMethods, 'traits' => $traitsMethods, $interfaceMethods] as $type => $typeMethods) {
            foreach ($typeMethods as $method) {
                $methodName = \strtolower($method->getName());
                if (!\array_key_exists($methodName, $methods)) {
                    $methods[$methodName] = $method;
                    continue;
                }
                if ($type !== 'traits') {
                    continue;
                }
                $existingMethod = $methods[$methodName];
                // Non-abstract trait method can overwrite existing methods:
                // - when existing method comes from parent class
                // - when existing method comes from trait and is abstract
                if (!(!$method->isAbstract() && ($existingMethod->getDeclaringClass()->getName() !== $this->getName() || $existingMethod->isAbstract() && $existingMethod->getDeclaringClass()->isTrait()))) {
                    continue;
                }
                $methods[$methodName] = $method;
            }
        }
        $this->cachedMethods = $methods;
        return $this->cachedMethods;
    }
    /**
     * Fetch an array of all methods for this class.
     *
     * Filter the results to include only methods with certain attributes. Defaults
     * to no filtering.
     * Any combination of \ReflectionMethod::IS_STATIC,
     * \ReflectionMethod::IS_PUBLIC,
     * \ReflectionMethod::IS_PROTECTED,
     * \ReflectionMethod::IS_PRIVATE,
     * \ReflectionMethod::IS_ABSTRACT,
     * \ReflectionMethod::IS_FINAL.
     * For example if $filter = \ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_FINAL
     * the only the final public methods will be returned
     *
     * @return list<ReflectionMethod>
     */
    public function getMethods(?int $filter = null) : array
    {
        if ($filter === null) {
            return \array_values($this->getMethodsIndexedByName());
        }
        return \array_values(\array_filter($this->getMethodsIndexedByName(), static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod $method) use($filter) : bool {
            return (bool) ($filter & $method->getModifiers());
        }));
    }
    /**
     * Get only the methods that this class implements (i.e. do not search
     * up parent classes etc.)
     *
     * @see ReflectionClass::getMethods for the usage of $filter
     *
     * @return ReflectionMethod[]
     */
    public function getImmediateMethods(?int $filter = null) : array
    {
        /** @var ReflectionMethod[] $methods */
        $methods = \array_map(function (\PhpParser\Node\Stmt\ClassMethod $methodNode) : ReflectionMethod {
            return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod::createFromNode($this->reflector, $methodNode, $this->declaringNamespace, $this, $this);
        }, $this->node->getMethods());
        $methodsByName = [];
        foreach ($methods as $method) {
            if ($filter !== null && !($filter & $method->getModifiers())) {
                continue;
            }
            $methodsByName[$method->getName()] = $method;
        }
        return $methodsByName;
    }
    /**
     * Get a single method with the name $methodName.
     *
     * @throws OutOfBoundsException
     */
    public function getMethod(string $methodName) : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod
    {
        $lowercaseMethodName = \strtolower($methodName);
        $methods = $this->getMethodsIndexedByName();
        if (!isset($methods[$lowercaseMethodName])) {
            throw new \OutOfBoundsException('Could not find method: ' . $methodName);
        }
        return $methods[$lowercaseMethodName];
    }
    /**
     * Does the class have the specified method method?
     */
    public function hasMethod(string $methodName) : bool
    {
        try {
            $this->getMethod($methodName);
            return \true;
        } catch (\OutOfBoundsException $exception) {
            return \false;
        }
    }
    /**
     * Get an associative array of only the constants for this specific class (i.e. do not search
     * up parent classes etc.), with keys as constant names and values as constant values.
     *
     * @return array<string, scalar|array<scalar>|null>
     */
    public function getImmediateConstants() : array
    {
        return \array_map(static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClassConstant $classConstant) {
            return $classConstant->getValue();
        }, $this->getImmediateReflectionConstants());
    }
    /**
     * Get an associative array of the defined constants in this class,
     * with keys as constant names and values as constant values.
     *
     * @return array<string, scalar|array<scalar>|null>
     */
    public function getConstants() : array
    {
        return \array_map(static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClassConstant $classConstant) {
            return $classConstant->getValue();
        }, $this->getReflectionConstants());
    }
    /**
     * Get the value of the specified class constant.
     *
     * Returns null if not specified.
     *
     * @return scalar|array<scalar>|null
     */
    public function getConstant(string $name)
    {
        $reflectionConstant = $this->getReflectionConstant($name);
        if (!$reflectionConstant) {
            return null;
        }
        return $reflectionConstant->getValue();
    }
    /**
     * Does this class have the specified constant?
     */
    public function hasConstant(string $name) : bool
    {
        return $this->getReflectionConstant($name) !== null;
    }
    /**
     * Get the reflection object of the specified class constant.
     *
     * Returns null if not specified.
     */
    public function getReflectionConstant(string $name) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClassConstant
    {
        return $this->getReflectionConstants()[$name] ?? null;
    }
    /**
     * Get an associative array of only the constants for this specific class (i.e. do not search
     * up parent classes etc.), with keys as constant names and values as {@see ReflectionClassConstant} objects.
     *
     * @return array<string, ReflectionClassConstant> indexed by name
     */
    public function getImmediateReflectionConstants() : array
    {
        if ($this->cachedReflectionConstants !== null) {
            return $this->cachedReflectionConstants;
        }
        $constants = \array_merge([], ...\array_map(function (\PhpParser\Node\Stmt\ClassConst $constNode) : array {
            $constants = [];
            foreach ($constNode->consts as $constantPositionInNode => $constantNode) {
                $constants[] = \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClassConstant::createFromNode($this->reflector, $constNode, $constantPositionInNode, $this);
            }
            return $constants;
        }, \array_filter($this->node->stmts, static function (\PhpParser\Node\Stmt $stmt) : bool {
            return $stmt instanceof \PhpParser\Node\Stmt\ClassConst;
        })));
        return $this->cachedReflectionConstants = \array_combine(\array_map(static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClassConstant $constant) : string {
            return $constant->getName();
        }, $constants), $constants);
    }
    /**
     * Get an associative array of the defined constants in this class,
     * with keys as constant names and values as {@see ReflectionClassConstant} objects.
     *
     * @return array<string, ReflectionClassConstant> indexed by name
     */
    public function getReflectionConstants() : array
    {
        // Note: constants are not merged via their name as array index, since internal PHP constant
        //       sorting does not follow `\array_merge()` semantics
        /** @var ReflectionClassConstant[] $allReflectionConstants */
        $allReflectionConstants = \array_merge(\array_values($this->getImmediateReflectionConstants()), ...\array_map(static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $ancestor) : array {
            return \array_filter(\array_values($ancestor->getReflectionConstants()), static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClassConstant $classConstant) : bool {
                return !$classConstant->isPrivate();
            });
        }, \array_filter([$this->getParentClass()])), ...\array_map(static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $interface) : array {
            return \array_values($interface->getReflectionConstants());
        }, \array_values($this->getInterfaces())));
        $reflectionConstants = [];
        foreach ($allReflectionConstants as $constant) {
            $constantName = $constant->getName();
            if (isset($reflectionConstants[$constantName])) {
                continue;
            }
            $reflectionConstants[$constantName] = $constant;
        }
        return $reflectionConstants;
    }
    /**
     * Get the constructor method for this class.
     *
     * @throws OutOfBoundsException
     */
    public function getConstructor() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod
    {
        $constructors = \array_values(\array_filter($this->getMethods(), static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionMethod $method) : bool {
            return $method->isConstructor();
        }));
        if (!isset($constructors[0])) {
            throw new \OutOfBoundsException('Could not find method: __construct');
        }
        return $constructors[0];
    }
    /**
     * Get only the properties for this specific class (i.e. do not search
     * up parent classes etc.)
     *
     * @see ReflectionClass::getProperties() for the usage of filter
     *
     * @return array<string, ReflectionProperty>
     */
    public function getImmediateProperties(?int $filter = null) : array
    {
        if ($this->cachedImmediateProperties === null) {
            $properties = [];
            foreach ($this->node->stmts as $stmt) {
                if ($stmt instanceof \PhpParser\Node\Stmt\ClassMethod && $stmt->name->toLowerString() === '__construct') {
                    foreach ($stmt->params as $param) {
                        if ($param->flags === 0) {
                            continue;
                        }
                        if (!$param->var instanceof \PhpParser\Node\Expr\Variable || !\is_string($param->var->name)) {
                            throw new \LogicException('Param should have a name.');
                        }
                        $prop = \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty::createFromNode($this->reflector, new \PhpParser\Node\Stmt\Property($param->flags, [new \PhpParser\Node\Stmt\PropertyProperty(new \PhpParser\Node\VarLikeIdentifier($param->var->name))], $param->getAttributes(), $param->type, $param->attrGroups), 0, $this->declaringNamespace, $this, $this, \true, \true);
                        $properties[$prop->getName()] = $prop;
                    }
                }
                if (!$stmt instanceof \PhpParser\Node\Stmt\Property) {
                    continue;
                }
                foreach ($stmt->props as $propertyPositionInNode => $propertyNode) {
                    $prop = \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty::createFromNode($this->reflector, $stmt, $propertyPositionInNode, $this->declaringNamespace, $this, $this);
                    $properties[$prop->getName()] = $prop;
                }
            }
            $this->cachedImmediateProperties = $properties;
        }
        if ($filter === null) {
            return $this->cachedImmediateProperties;
        }
        return \array_filter($this->cachedImmediateProperties, static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $property) use($filter) : bool {
            return (bool) ($filter & $property->getModifiers());
        });
    }
    /**
     * Get the properties for this class.
     *
     * Filter the results to include only properties with certain attributes. Defaults
     * to no filtering.
     * Any combination of \ReflectionProperty::IS_STATIC,
     * \ReflectionProperty::IS_PUBLIC,
     * \ReflectionProperty::IS_PROTECTED,
     * \ReflectionProperty::IS_PRIVATE.
     * For example if $filter = \ReflectionProperty::IS_STATIC | \ReflectionProperty::IS_PUBLIC
     * only the static public properties will be returned
     *
     * @return array<string, ReflectionProperty>
     */
    public function getProperties(?int $filter = null) : array
    {
        if ($this->cachedProperties === null) {
            // merging together properties from parent class, traits, current class (in this precise order)
            $this->cachedProperties = \array_merge(\array_merge([], ...\array_map(static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $ancestor) use($filter) : array {
                return \array_filter($ancestor->getProperties($filter), static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $property) : bool {
                    return !$property->isPrivate();
                });
            }, \array_filter([$this->getParentClass()])), ...\array_map(function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $trait) use($filter) {
                return \array_map(function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $property) use($trait) : ReflectionProperty {
                    return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty::createFromNode($this->reflector, $property->getAst(), $property->getPositionInAst(), $trait->declaringNamespace, $property->getDeclaringClass(), $this, $property->isDefault(), $property->isPromoted());
                }, $trait->getProperties($filter));
            }, $this->getTraits())), $this->getImmediateProperties());
        }
        if ($filter === null) {
            return $this->cachedProperties;
        }
        return \array_filter($this->cachedProperties, static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $property) use($filter) : bool {
            return (bool) ($filter & $property->getModifiers());
        });
    }
    /**
     * Get the property called $name.
     *
     * Returns null if property does not exist.
     */
    public function getProperty(string $name) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty
    {
        $properties = $this->getProperties();
        if (!isset($properties[$name])) {
            return null;
        }
        return $properties[$name];
    }
    /**
     * Does this class have the specified property?
     */
    public function hasProperty(string $name) : bool
    {
        return $this->getProperty($name) !== null;
    }
    /**
     * @return array<string, scalar|array<scalar>|null>
     */
    public function getDefaultProperties() : array
    {
        return \array_map(static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $property) {
            return $property->getDefaultValue();
        }, \array_filter($this->getProperties(), static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $property) : bool {
            return $property->isDefault();
        }));
    }
    public function getFileName() : ?string
    {
        return $this->locatedSource->getFileName();
    }
    public function getLocatedSource() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource
    {
        return $this->locatedSource;
    }
    /**
     * Get the line number that this class starts on.
     */
    public function getStartLine() : int
    {
        return $this->node->getStartLine();
    }
    /**
     * Get the line number that this class ends on.
     */
    public function getEndLine() : int
    {
        return $this->node->getEndLine();
    }
    public function getStartColumn() : int
    {
        return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\CalculateReflectionColum::getStartColumn($this->locatedSource->getSource(), $this->node);
    }
    public function getEndColumn() : int
    {
        return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\CalculateReflectionColum::getEndColumn($this->locatedSource->getSource(), $this->node);
    }
    /**
     * Get the parent class, if it is defined. If this class does not have a
     * specified parent class, this will throw an exception.
     *
     * @throws NotAClassReflection
     */
    public function getParentClass() : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass
    {
        if (!$this->node instanceof \PhpParser\Node\Stmt\Class_ || $this->node->extends === null) {
            return null;
        }
        if ($this->cachedParentClass === null) {
            $parent = $this->reflector->reflect($this->node->extends->toString());
            // @TODO use actual `ClassReflector` or `FunctionReflector`?
            \assert($parent instanceof self);
            $this->cachedParentClass = $parent;
        }
        if ($this->cachedParentClass->isInterface() || $this->cachedParentClass->isTrait()) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection::fromReflectionClass($this->cachedParentClass);
        }
        return $this->cachedParentClass;
    }
    /**
     * Gets the parent class names.
     *
     * @return list<class-string> A numerical array with parent class names as the values.
     */
    public function getParentClassNames() : array
    {
        return \array_map(static function (self $parentClass) : string {
            return $parentClass->getName();
        }, \array_slice(\array_reverse($this->getInheritanceClassHierarchy()), 1));
    }
    public function getDocComment() : string
    {
        return \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\GetLastDocComment::forNode($this->node);
    }
    public function isAnonymous() : bool
    {
        return $this->node->name === null;
    }
    /**
     * Is this an internal class?
     */
    public function isInternal() : bool
    {
        return $this->locatedSource->isInternal();
    }
    /**
     * Is this a user-defined function (will always return the opposite of
     * whatever isInternal returns).
     */
    public function isUserDefined() : bool
    {
        return !$this->isInternal();
    }
    /**
     * Is this class an abstract class.
     */
    public function isAbstract() : bool
    {
        return $this->node instanceof \PhpParser\Node\Stmt\Class_ && $this->node->isAbstract();
    }
    /**
     * Is this class a final class.
     */
    public function isFinal() : bool
    {
        return $this->node instanceof \PhpParser\Node\Stmt\Class_ && $this->node->isFinal();
    }
    /**
     * Get the core-reflection-compatible modifier values.
     */
    public function getModifiers() : int
    {
        $val = 0;
        $val += $this->isAbstract() ? \ReflectionClass::IS_EXPLICIT_ABSTRACT : 0;
        $val += $this->isFinal() ? \ReflectionClass::IS_FINAL : 0;
        return $val;
    }
    /**
     * Is this reflection a trait?
     */
    public function isTrait() : bool
    {
        return $this->node instanceof \PhpParser\Node\Stmt\Trait_;
    }
    /**
     * Is this reflection an interface?
     */
    public function isInterface() : bool
    {
        return $this->node instanceof \PhpParser\Node\Stmt\Interface_;
    }
    /**
     * Get the traits used, if any are defined. If this class does not have any
     * defined traits, this will return an empty array.
     *
     * @return list<ReflectionClass>
     */
    public function getTraits() : array
    {
        return \array_map(function (\PhpParser\Node\Name $importedTrait) : ReflectionClass {
            return $this->reflectClassForNamedNode($importedTrait);
        }, \array_merge([], ...\array_map(static function (\PhpParser\Node\Stmt\TraitUse $traitUse) : array {
            return $traitUse->traits;
        }, \array_filter($this->node->stmts, static function (\PhpParser\Node $node) : bool {
            return $node instanceof \PhpParser\Node\Stmt\TraitUse;
        }))));
    }
    /**
     * Given an AST Node\Name, create a new ReflectionClass for the element.
     */
    private function reflectClassForNamedNode(\PhpParser\Node\Name $node) : self
    {
        // @TODO use actual `ClassReflector` or `FunctionReflector`?
        if ($this->isAnonymous()) {
            $class = (new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\BetterReflection())->classReflector()->reflect($node->toString());
        } else {
            $class = $this->reflector->reflect($node->toString());
            \assert($class instanceof self);
        }
        return $class;
    }
    /**
     * Get the names of the traits used as an array of strings, if any are
     * defined. If this class does not have any defined traits, this will
     * return an empty array.
     *
     * @return string[]
     */
    public function getTraitNames() : array
    {
        return \array_map(static function (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $trait) : string {
            return $trait->getName();
        }, $this->getTraits());
    }
    /**
     * Return a list of the aliases used when importing traits for this class.
     * The returned array is in key/value pair in this format:.
     *
     *   'aliasedMethodName' => 'ActualClass::actualMethod'
     *
     * @return array<string, string>
     *
     * @example
     * // When reflecting a class such as:
     * class Foo
     * {
     *     use MyTrait {
     *         myTraitMethod as myAliasedMethod;
     *     }
     * }
     * // This method would return
     * //   ['myAliasedMethod' => 'MyTrait::myTraitMethod']
     */
    public function getTraitAliases() : array
    {
        $this->parseTraitUsages();
        /** @return array<string, string> */
        return $this->cachedTraitAliases;
    }
    /**
     * Return a list of the precedences used when importing traits for this class.
     * The returned array is in key/value pair in this format:.
     *
     *   'Class::method' => 'Class::method'
     *
     * @return array<string, string>
     *
     * @example
     * // When reflecting a class such as:
     * class Foo
     * {
     *     use MyTrait, MyTrait2 {
     *         MyTrait2::foo insteadof MyTrait1;
     *     }
     * }
     * // This method would return
     * //   ['MyTrait1::foo' => 'MyTrait2::foo']
     */
    private function getTraitPrecedences() : array
    {
        $this->parseTraitUsages();
        /** @return array<string, string> */
        return $this->cachedTraitPrecedences;
    }
    private function parseTraitUsages() : void
    {
        if ($this->cachedTraitAliases !== null && $this->cachedTraitPrecedences !== null) {
            return;
        }
        /** @var Node\Stmt\TraitUse[] $traitUsages */
        $traitUsages = \array_filter($this->node->stmts, static function (\PhpParser\Node $node) : bool {
            return $node instanceof \PhpParser\Node\Stmt\TraitUse;
        });
        $this->cachedTraitAliases = [];
        $this->cachedTraitPrecedences = [];
        foreach ($traitUsages as $traitUsage) {
            $traitNames = $traitUsage->traits;
            $adaptations = $traitUsage->adaptations;
            foreach ($adaptations as $adaptation) {
                $usedTrait = $adaptation->trait;
                if ($usedTrait === null) {
                    $usedTrait = $traitNames[0];
                }
                if ($adaptation instanceof \PhpParser\Node\Stmt\TraitUseAdaptation\Alias && $adaptation->newName) {
                    $this->cachedTraitAliases[$adaptation->newName->name] = $this->methodHash($usedTrait->toString(), $adaptation->method->toString());
                    continue;
                }
                if (!$adaptation instanceof \PhpParser\Node\Stmt\TraitUseAdaptation\Precedence || !$adaptation->insteadof) {
                    continue;
                }
                foreach ($adaptation->insteadof as $insteadof) {
                    $adaptationNameHash = $this->methodHash($insteadof->toString(), $adaptation->method->toString());
                    $originalNameHash = $this->methodHash($usedTrait->toString(), $adaptation->method->toString());
                    $this->cachedTraitPrecedences[$adaptationNameHash] = $originalNameHash;
                }
            }
        }
    }
    /**
     * @psalm-pure
     */
    private function methodHash(string $className, string $methodName) : string
    {
        return \sprintf('%s::%s', $className, $methodName);
    }
    /**
     * Gets the interfaces.
     *
     * @link https://php.net/manual/en/reflectionclass.getinterfaces.php
     *
     * @return array<string, ReflectionClass> An associative array of interfaces, with keys as interface names and the array
     *                                        values as {@see ReflectionClass} objects.
     */
    public function getInterfaces() : array
    {
        return \array_merge(...\array_map(static function (self $reflectionClass) : array {
            return $reflectionClass->getCurrentClassImplementedInterfacesIndexedByName();
        }, $this->getInheritanceClassHierarchy()));
    }
    /**
     * Get only the interfaces that this class implements (i.e. do not search
     * up parent classes etc.)
     *
     * @return array<string, ReflectionClass>
     */
    public function getImmediateInterfaces() : array
    {
        if ($this->isTrait()) {
            return [];
        }
        \assert($this->node instanceof \PhpParser\Node\Stmt\Class_ || $this->node instanceof \PhpParser\Node\Stmt\Interface_);
        $nodes = $this->node instanceof \PhpParser\Node\Stmt\Interface_ ? $this->node->extends : $this->node->implements;
        return \array_combine(\array_map(static function (\PhpParser\Node\Name $interfaceName) : string {
            return $interfaceName->toString();
        }, $nodes), \array_map(function (\PhpParser\Node\Name $interfaceName) : ReflectionClass {
            return $this->reflectClassForNamedNode($interfaceName);
        }, $nodes));
    }
    /**
     * Gets the interface names.
     *
     * @link https://php.net/manual/en/reflectionclass.getinterfacenames.php
     *
     * @return list<string> A numerical array with interface names as the values.
     */
    public function getInterfaceNames() : array
    {
        return \array_values(\array_map(static function (self $interface) : string {
            return $interface->getName();
        }, $this->getInterfaces()));
    }
    /**
     * Checks whether the given object is an instance.
     *
     * @link https://php.net/manual/en/reflectionclass.isinstance.php
     *
     * @param object $object
     */
    public function isInstance($object) : bool
    {
        if (!\is_object($object)) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnObject::fromNonObject($object);
        }
        $className = $this->getName();
        // note: since $object was loaded, we can safely assume that $className is available in the current
        //       php script execution context
        return $object instanceof $className;
    }
    /**
     * Checks whether the given class string is a subclass of this class.
     *
     * @link https://php.net/manual/en/reflectionclass.isinstance.php
     */
    public function isSubclassOf(string $className) : bool
    {
        return \in_array(\ltrim($className, '\\'), \array_map(static function (self $reflectionClass) : string {
            return $reflectionClass->getName();
        }, \array_slice(\array_reverse($this->getInheritanceClassHierarchy()), 1)), \true);
    }
    /**
     * Checks whether this class implements the given interface.
     *
     * @link https://php.net/manual/en/reflectionclass.implementsinterface.php
     */
    public function implementsInterface(string $interfaceName) : bool
    {
        return \in_array(\ltrim($interfaceName, '\\'), $this->getInterfaceNames(), \true);
    }
    /**
     * Checks whether this reflection is an instantiable class
     *
     * @link https://php.net/manual/en/reflectionclass.isinstantiable.php
     */
    public function isInstantiable() : bool
    {
        // @TODO doesn't consider internal non-instantiable classes yet.
        if ($this->isAbstract()) {
            return \false;
        }
        if ($this->isInterface()) {
            return \false;
        }
        if ($this->isTrait()) {
            return \false;
        }
        try {
            return $this->getConstructor()->isPublic();
        } catch (\OutOfBoundsException $e) {
            return \true;
        }
    }
    /**
     * Checks whether this is a reflection of a class that supports the clone operator
     *
     * @link https://php.net/manual/en/reflectionclass.iscloneable.php
     */
    public function isCloneable() : bool
    {
        if (!$this->isInstantiable()) {
            return \false;
        }
        if (!$this->hasMethod('__clone')) {
            return \true;
        }
        return $this->getMethod('__clone')->isPublic();
    }
    /**
     * Checks if iterateable
     *
     * @link https://php.net/manual/en/reflectionclass.isiterateable.php
     */
    public function isIterateable() : bool
    {
        return $this->isInstantiable() && $this->implementsInterface(\Traversable::class);
    }
    /**
     * @return array<string, ReflectionClass>
     */
    private function getCurrentClassImplementedInterfacesIndexedByName() : array
    {
        $node = $this->node;
        if ($node instanceof \PhpParser\Node\Stmt\Class_) {
            $interfaces = \array_merge([], ...\array_map(function (\PhpParser\Node\Name $interfaceName) : array {
                return $this->reflectClassForNamedNode($interfaceName)->getInterfacesHierarchy();
            }, $node->implements));
            if (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\BetterReflection::$phpVersion >= 80000) {
                foreach ($node->getMethods() as $method) {
                    if ($method->name->toLowerString() !== '__tostring') {
                        continue;
                    }
                    foreach ($interfaces as $interface) {
                        if ($interface->getName() === 'Stringable') {
                            return $interfaces;
                        }
                    }
                    $interfaces['Stringable'] = $this->reflectClassForNamedNode(new \PhpParser\Node\Name('Stringable'));
                    break;
                }
            }
            return $interfaces;
        }
        // assumption: first key is the current interface
        return $this->isInterface() ? \array_slice($this->getInterfacesHierarchy(), 1) : [];
    }
    /**
     * @return ReflectionClass[] ordered from inheritance root to leaf (this class)
     */
    private function getInheritanceClassHierarchy() : array
    {
        if ($this->cachedInheritanceClassHierarchy === null) {
            $parentClass = $this->getParentClass();
            $this->cachedInheritanceClassHierarchy = $parentClass ? \array_merge($parentClass->getInheritanceClassHierarchy(), [$this]) : [$this];
        }
        return $this->cachedInheritanceClassHierarchy;
    }
    /**
     * This method allows us to retrieve all interfaces parent of the this interface. Do not use on class nodes!
     *
     * @return array<string, ReflectionClass> parent interfaces of this interface
     *
     * @throws NotAnInterfaceReflection
     */
    private function getInterfacesHierarchy() : array
    {
        if (!$this->isInterface()) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection::fromReflectionClass($this);
        }
        $node = $this->node;
        \assert($node instanceof \PhpParser\Node\Stmt\Interface_);
        $interfaces = \array_merge([$this->getName() => $this], ...\array_map(function (\PhpParser\Node\Name $interfaceName) : array {
            return $this->reflectClassForNamedNode($interfaceName)->getInterfacesHierarchy();
        }, $node->extends));
        if (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\BetterReflection::$phpVersion >= 80000) {
            foreach ($node->getMethods() as $method) {
                if ($method->name->toLowerString() !== '__tostring') {
                    continue;
                }
                foreach ($interfaces as $interface) {
                    if ($interface->getName() === 'Stringable') {
                        return $interfaces;
                    }
                }
                $interfaces['Stringable'] = $this->reflectClassForNamedNode(new \PhpParser\Node\Name('Stringable'));
                break;
            }
        }
        return $interfaces;
    }
    /**
     * @throws Uncloneable
     */
    public function __clone()
    {
        throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\Uncloneable::fromClass(static::class);
    }
    /**
     * Get the value of a static property, if it exists. Throws a
     * PropertyDoesNotExist exception if it does not exist or is not static.
     * (note, differs very slightly from internal reflection behaviour)
     *
     * @return mixed
     *
     * @throws ClassDoesNotExist
     * @throws NoObjectProvided
     * @throws NotAnObject
     * @throws ObjectNotInstanceOfClass
     */
    public function getStaticPropertyValue(string $propertyName)
    {
        $property = $this->getProperty($propertyName);
        if (!$property || !$property->isStatic()) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\PropertyDoesNotExist::fromName($propertyName);
        }
        return $property->getValue();
    }
    /**
     * Set the value of a static property
     *
     * @param mixed $value
     *
     * @throws ClassDoesNotExist
     * @throws NoObjectProvided
     * @throws NotAnObject
     * @throws ObjectNotInstanceOfClass
     */
    public function setStaticPropertyValue(string $propertyName, $value) : void
    {
        $property = $this->getProperty($propertyName);
        if (!$property || !$property->isStatic()) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\PropertyDoesNotExist::fromName($propertyName);
        }
        $property->setValue($value);
    }
    /**
     * @return array<string, mixed>
     */
    public function getStaticProperties() : array
    {
        $staticProperties = [];
        foreach ($this->getProperties() as $property) {
            if (!$property->isStatic()) {
                continue;
            }
            $staticProperties[$property->getName()] = $property->getValue();
        }
        return $staticProperties;
    }
    /**
     * Retrieve the AST node for this class
     */
    public function getAst() : \PhpParser\Node\Stmt\ClassLike
    {
        return $this->node;
    }
    public function getDeclaringNamespaceAst() : ?\PhpParser\Node\Stmt\Namespace_
    {
        return $this->declaringNamespace;
    }
    /**
     * Set whether this class is final or not
     *
     * @throws NotAClassReflection
     */
    public function setFinal(bool $isFinal) : void
    {
        if (!$this->node instanceof \PhpParser\Node\Stmt\Class_) {
            throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection::fromReflectionClass($this);
        }
        if ($isFinal === \true) {
            $this->node->flags |= \PhpParser\Node\Stmt\Class_::MODIFIER_FINAL;
            return;
        }
        $this->node->flags &= ~\PhpParser\Node\Stmt\Class_::MODIFIER_FINAL;
    }
    /**
     * Remove the named method from the class.
     *
     * Returns true if method was successfully removed.
     * Returns false if method was not found, or could not be removed.
     */
    public function removeMethod(string $methodName) : bool
    {
        $lowerName = \strtolower($methodName);
        foreach ($this->node->stmts as $key => $stmt) {
            if ($stmt instanceof \PhpParser\Node\Stmt\ClassMethod && $lowerName === $stmt->name->toLowerString()) {
                unset($this->node->stmts[$key]);
                $this->cachedMethods = null;
                return \true;
            }
        }
        return \false;
    }
    /**
     * Add a new method to the class.
     */
    public function addMethod(string $methodName) : void
    {
        $this->node->stmts[] = new \PhpParser\Node\Stmt\ClassMethod($methodName);
        $this->cachedMethods = null;
    }
    /**
     * Add a new property to the class.
     *
     * Visibility defaults to \ReflectionProperty::IS_PUBLIC, or can be ::IS_PROTECTED or ::IS_PRIVATE.
     */
    public function addProperty(string $propertyName, int $visibility = \ReflectionProperty::IS_PUBLIC, bool $static = \false) : void
    {
        $type = 0;
        switch ($visibility) {
            case \ReflectionProperty::IS_PRIVATE:
                $type |= \PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE;
                break;
            case \ReflectionProperty::IS_PROTECTED:
                $type |= \PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED;
                break;
            default:
                $type |= \PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC;
                break;
        }
        if ($static) {
            $type |= \PhpParser\Node\Stmt\Class_::MODIFIER_STATIC;
        }
        $this->node->stmts[] = new \PhpParser\Node\Stmt\Property($type, [new \PhpParser\Node\Stmt\PropertyProperty($propertyName)]);
        $this->cachedProperties = null;
        $this->cachedImmediateProperties = null;
    }
    /**
     * Remove a property from the class.
     */
    public function removeProperty(string $propertyName) : bool
    {
        $lowerName = \strtolower($propertyName);
        foreach ($this->node->stmts as $key => $stmt) {
            if (!$stmt instanceof \PhpParser\Node\Stmt\Property) {
                continue;
            }
            $propertyNames = \array_map(static function (\PhpParser\Node\Stmt\PropertyProperty $propertyProperty) : string {
                return $propertyProperty->name->toLowerString();
            }, $stmt->props);
            if (\in_array($lowerName, $propertyNames, \true)) {
                $this->cachedProperties = null;
                $this->cachedImmediateProperties = null;
                unset($this->node->stmts[$key]);
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return ReflectionAttribute[]
     */
    public function getAttributes() : array
    {
        $attributes = [];
        $compileNodeToValue = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompileNodeToValue();
        foreach ($this->node->attrGroups as $attrGroup) {
            foreach ($attrGroup->attrs as $attr) {
                $arguments = [];
                foreach ($attr->args as $i => $arg) {
                    $key = $i;
                    if ($arg->name !== null) {
                        $key = $arg->name->toString();
                    }
                    $arguments[$key] = $compileNodeToValue->__invoke($arg->value, new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\CompilerContext($this->reflector, $this->getFileName(), $this, $this->declaringNamespace !== null && $this->declaringNamespace->name !== null ? $this->declaringNamespace->name->toString() : null, null));
                }
                $attributes[] = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionAttribute($attr->name->toString(), $arguments);
            }
        }
        return $attributes;
    }
}
