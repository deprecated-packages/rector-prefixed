<?php

declare (strict_types=1);
namespace Rector\Naming\Naming;

use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StaticType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Naming\RectorNamingInflector;
use Rector\Naming\ValueObject\ExpectedName;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
use Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType;
/**
 * @deprecated
 * @todo merge with very similar logic in
 * @see VariableNaming
 * @see \Rector\Tests\Naming\Naming\PropertyNamingTest
 */
final class PropertyNaming
{
    /**
     * @var string[]
     */
    private const EXCLUDED_CLASSES = ['#Closure#', '#^Spl#', '#FileInfo#', '#^std#', '#Iterator#', '#SimpleXML#'];
    /**
     * @var string
     */
    private const INTERFACE = 'Interface';
    /**
     * @see https://regex101.com/r/RDhBNR/1
     * @var string
     */
    private const PREFIXED_CLASS_METHODS_REGEX = '#^(is|are|was|were|has|have|had|can)[A-Z].+#';
    /**
     * @var string
     * @see https://regex101.com/r/U78rUF/1
     */
    private const I_PREFIX_REGEX = '#^I[A-Z]#';
    /**
     * @see https://regex101.com/r/hnU5pm/2/
     * @var string
     */
    private const GET_PREFIX_REGEX = '#^get(?<root_name>[A-Z].+)#';
    /**
     * @var TypeUnwrapper
     */
    private $typeUnwrapper;
    /**
     * @var RectorNamingInflector
     */
    private $rectorNamingInflector;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \Rector\Naming\RectorNamingInflector $rectorNamingInflector, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->typeUnwrapper = $typeUnwrapper;
        $this->rectorNamingInflector = $rectorNamingInflector;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getExpectedNameFromMethodName(string $methodName) : ?\Rector\Naming\ValueObject\ExpectedName
    {
        $matches = \RectorPrefix20210408\Nette\Utils\Strings::match($methodName, self::GET_PREFIX_REGEX);
        if ($matches === null) {
            return null;
        }
        $originalName = \lcfirst($matches['root_name']);
        return new \Rector\Naming\ValueObject\ExpectedName($originalName, $this->rectorNamingInflector->singularize($originalName));
    }
    public function getExpectedNameFromType(\PHPStan\Type\Type $type) : ?\Rector\Naming\ValueObject\ExpectedName
    {
        $type = $this->typeUnwrapper->unwrapNullableType($type);
        if (!$type instanceof \PHPStan\Type\TypeWithClassName) {
            return null;
        }
        if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\SelfObjectType) {
            return null;
        }
        if ($type instanceof \PHPStan\Type\StaticType) {
            return null;
        }
        $className = $this->nodeTypeResolver->getFullyQualifiedClassName($type);
        foreach (self::EXCLUDED_CLASSES as $excludedClass) {
            if (\RectorPrefix20210408\Nette\Utils\Strings::match($className, $excludedClass)) {
                return null;
            }
        }
        $shortClassName = $this->resolveShortClassName($className);
        $shortClassName = $this->removePrefixesAndSuffixes($shortClassName);
        // if all is upper-cased, it should be lower-cased
        if ($shortClassName === \strtoupper($shortClassName)) {
            $shortClassName = \strtolower($shortClassName);
        }
        // remove "_"
        $shortClassName = \RectorPrefix20210408\Nette\Utils\Strings::replace($shortClassName, '#_#', '');
        $shortClassName = $this->normalizeUpperCase($shortClassName);
        // prolong too short generic names with one namespace up
        $originalName = $this->prolongIfTooShort($shortClassName, $className);
        return new \Rector\Naming\ValueObject\ExpectedName($originalName, $this->rectorNamingInflector->singularize($originalName));
    }
    /**
     * @param ObjectType|string $objectType
     */
    public function fqnToVariableName($objectType) : string
    {
        $className = $this->resolveClassName($objectType);
        $shortName = $this->fqnToShortName($className);
        $shortName = $this->removeInterfaceSuffixPrefix($className, $shortName);
        // prolong too short generic names with one namespace up
        return $this->prolongIfTooShort($shortName, $className);
    }
    /**
     * @source https://stackoverflow.com/a/2792045/1348344
     */
    public function underscoreToName(string $underscoreName) : string
    {
        $uppercaseWords = \ucwords($underscoreName, '_');
        $pascalCaseName = \str_replace('_', '', $uppercaseWords);
        return \lcfirst($pascalCaseName);
    }
    public function getExpectedNameFromBooleanPropertyType(\PhpParser\Node\Stmt\Property $property) : ?string
    {
        $prefixedClassMethods = $this->getPrefixedClassMethods($property);
        if ($prefixedClassMethods === []) {
            return null;
        }
        $classMethods = $this->filterClassMethodsWithPropertyFetchReturnOnly($prefixedClassMethods, $property);
        if (\count($classMethods) !== 1) {
            return null;
        }
        $classMethod = \reset($classMethods);
        return $this->nodeNameResolver->getName($classMethod);
    }
    private function resolveShortClassName(string $className) : string
    {
        if (\RectorPrefix20210408\Nette\Utils\Strings::contains($className, '\\')) {
            return \RectorPrefix20210408\Nette\Utils\Strings::after($className, '\\', -1);
        }
        return $className;
    }
    private function removePrefixesAndSuffixes(string $shortClassName) : string
    {
        // is SomeInterface
        if (\RectorPrefix20210408\Nette\Utils\Strings::endsWith($shortClassName, self::INTERFACE)) {
            $shortClassName = \RectorPrefix20210408\Nette\Utils\Strings::substring($shortClassName, 0, -\strlen(self::INTERFACE));
        }
        // is ISomeClass
        if ($this->isPrefixedInterface($shortClassName)) {
            $shortClassName = \RectorPrefix20210408\Nette\Utils\Strings::substring($shortClassName, 1);
        }
        // is AbstractClass
        if (\RectorPrefix20210408\Nette\Utils\Strings::startsWith($shortClassName, 'Abstract')) {
            $shortClassName = \RectorPrefix20210408\Nette\Utils\Strings::substring($shortClassName, \strlen('Abstract'));
        }
        return $shortClassName;
    }
    private function normalizeUpperCase(string $shortClassName) : string
    {
        // turns $SOMEUppercase => $someUppercase
        for ($i = 0; $i <= \strlen($shortClassName); ++$i) {
            if (\ctype_upper($shortClassName[$i]) && $this->isNumberOrUpper($shortClassName[$i + 1])) {
                $shortClassName[$i] = \strtolower($shortClassName[$i]);
            } else {
                break;
            }
        }
        return $shortClassName;
    }
    private function prolongIfTooShort(string $shortClassName, string $className) : string
    {
        if (\in_array($shortClassName, ['Factory', 'Repository'], \true)) {
            $namespaceAbove = (string) \RectorPrefix20210408\Nette\Utils\Strings::after($className, '\\', -2);
            $namespaceAbove = (string) \RectorPrefix20210408\Nette\Utils\Strings::before($namespaceAbove, '\\');
            return \lcfirst($namespaceAbove) . $shortClassName;
        }
        return \lcfirst($shortClassName);
    }
    /**
     * @param ObjectType|string $objectType
     */
    private function resolveClassName($objectType) : string
    {
        if ($objectType instanceof \PHPStan\Type\ObjectType) {
            return $objectType->getClassName();
        }
        return $objectType;
    }
    private function fqnToShortName(string $fqn) : string
    {
        if (!\RectorPrefix20210408\Nette\Utils\Strings::contains($fqn, '\\')) {
            return $fqn;
        }
        /** @var string $lastNamePart */
        $lastNamePart = \RectorPrefix20210408\Nette\Utils\Strings::after($fqn, '\\', -1);
        if (\RectorPrefix20210408\Nette\Utils\Strings::endsWith($lastNamePart, self::INTERFACE)) {
            return \RectorPrefix20210408\Nette\Utils\Strings::substring($lastNamePart, 0, -\strlen(self::INTERFACE));
        }
        return $lastNamePart;
    }
    private function removeInterfaceSuffixPrefix(string $className, string $shortName) : string
    {
        // remove interface prefix/suffix
        if (!$this->reflectionProvider->hasClass($className)) {
            return $shortName;
        }
        // starts with "I\W+"?
        if (\RectorPrefix20210408\Nette\Utils\Strings::match($shortName, self::I_PREFIX_REGEX)) {
            return \RectorPrefix20210408\Nette\Utils\Strings::substring($shortName, 1);
        }
        if (\RectorPrefix20210408\Nette\Utils\Strings::endsWith($shortName, self::INTERFACE)) {
            return \RectorPrefix20210408\Nette\Utils\Strings::substring($shortName, -\strlen(self::INTERFACE));
        }
        return $shortName;
    }
    /**
     * @return ClassMethod[]
     */
    private function getPrefixedClassMethods(\PhpParser\Node\Stmt\Property $property) : array
    {
        $classLike = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return [];
        }
        $classMethods = $this->betterNodeFinder->findInstanceOf($classLike, \PhpParser\Node\Stmt\ClassMethod::class);
        return \array_filter($classMethods, function (\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool {
            return $this->isBoolishMethodName($classMethod);
        });
    }
    /**
     * @param ClassMethod[] $prefixedClassMethods
     * @return ClassMethod[]
     */
    private function filterClassMethodsWithPropertyFetchReturnOnly(array $prefixedClassMethods, \PhpParser\Node\Stmt\Property $property) : array
    {
        $classMethodName = $this->nodeNameResolver->getName($property);
        return \array_filter($prefixedClassMethods, function (\PhpParser\Node\Stmt\ClassMethod $classMethod) use($classMethodName) : bool {
            return $this->doesClassMethodMatchReturnPropertyFetch($classMethod, $classMethodName);
        });
    }
    private function isPrefixedInterface(string $shortClassName) : bool
    {
        if (\strlen($shortClassName) <= 3) {
            return \false;
        }
        if (!\RectorPrefix20210408\Nette\Utils\Strings::startsWith($shortClassName, 'I')) {
            return \false;
        }
        if (!\ctype_upper($shortClassName[1])) {
            return \false;
        }
        return \ctype_lower($shortClassName[2]);
    }
    private function isNumberOrUpper(string $char) : bool
    {
        if (\ctype_upper($char)) {
            return \true;
        }
        return \ctype_digit($char);
    }
    private function isBoolishMethodName(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $classMethodName = $this->nodeNameResolver->getName($classMethod);
        return (bool) \RectorPrefix20210408\Nette\Utils\Strings::match($classMethodName, self::PREFIXED_CLASS_METHODS_REGEX);
    }
    private function doesClassMethodMatchReturnPropertyFetch(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $currentClassMethodName) : bool
    {
        $possibleReturn = $classMethod->stmts[0] ?? null;
        if (!$possibleReturn instanceof \PhpParser\Node\Stmt\Return_) {
            return \false;
        }
        $node = $possibleReturn->expr;
        if (!$node instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node->name, $currentClassMethodName);
    }
}
