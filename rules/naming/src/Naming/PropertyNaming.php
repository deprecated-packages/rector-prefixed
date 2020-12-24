<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Naming;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\Naming\RectorNamingInflector;
use _PhpScoper0a6b37af0871\Rector\Naming\ValueObject\ExpectedName;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\VariableNaming;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\SelfObjectType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
/**
 * @deprecated
 * @todo merge with very similar logic in
 * @see VariableNaming
 * @see \Rector\Naming\Tests\Naming\PropertyNamingTest
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
    private const GET_PREFIX_REGEX = '#^get([A-Z].+)#';
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \_PhpScoper0a6b37af0871\Rector\Naming\RectorNamingInflector $rectorNamingInflector, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->typeUnwrapper = $typeUnwrapper;
        $this->rectorNamingInflector = $rectorNamingInflector;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getExpectedNameFromMethodName(string $methodName) : ?\_PhpScoper0a6b37af0871\Rector\Naming\ValueObject\ExpectedName
    {
        $matches = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($methodName, self::GET_PREFIX_REGEX);
        if ($matches === null) {
            return null;
        }
        $originalName = \lcfirst($matches[1]);
        return new \_PhpScoper0a6b37af0871\Rector\Naming\ValueObject\ExpectedName($originalName, $this->rectorNamingInflector->singularize($originalName));
    }
    public function getExpectedNameFromType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : ?\_PhpScoper0a6b37af0871\Rector\Naming\ValueObject\ExpectedName
    {
        $type = $this->typeUnwrapper->unwrapNullableType($type);
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
            return null;
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\SelfObjectType) {
            return null;
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType) {
            return null;
        }
        $className = $this->getClassName($type);
        foreach (self::EXCLUDED_CLASSES as $excludedClass) {
            if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($className, $excludedClass)) {
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
        $shortClassName = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($shortClassName, '#_#', '');
        $shortClassName = $this->normalizeUpperCase($shortClassName);
        // prolong too short generic names with one namespace up
        $originalName = $this->prolongIfTooShort($shortClassName, $className);
        return new \_PhpScoper0a6b37af0871\Rector\Naming\ValueObject\ExpectedName($originalName, $this->rectorNamingInflector->singularize($originalName));
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
        $pascalCaseName = \str_replace('_', '', \ucwords($underscoreName, '_'));
        return \lcfirst($pascalCaseName);
    }
    public function getExpectedNameFromBooleanPropertyType(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : ?string
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
    private function getClassName(\_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        return $typeWithClassName->getClassName();
    }
    private function resolveShortClassName(string $className) : string
    {
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($className, '\\')) {
            return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($className, '\\', -1);
        }
        return $className;
    }
    private function removePrefixesAndSuffixes(string $shortClassName) : string
    {
        // is SomeInterface
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($shortClassName, self::INTERFACE)) {
            $shortClassName = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::substring($shortClassName, 0, -\strlen(self::INTERFACE));
        }
        // is ISomeClass
        if ($this->isPrefixedInterface($shortClassName)) {
            $shortClassName = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::substring($shortClassName, 1);
        }
        // is AbstractClass
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::startsWith($shortClassName, 'Abstract')) {
            $shortClassName = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::substring($shortClassName, \strlen('Abstract'));
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
            /** @var string $namespaceAbove */
            $namespaceAbove = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($className, '\\', -2);
            /** @var string $namespaceAbove */
            $namespaceAbove = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::before($namespaceAbove, '\\');
            return \lcfirst($namespaceAbove) . $shortClassName;
        }
        return \lcfirst($shortClassName);
    }
    /**
     * @param ObjectType|string $objectType
     */
    private function resolveClassName($objectType) : string
    {
        if ($objectType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
            return $objectType->getClassName();
        }
        return $objectType;
    }
    private function fqnToShortName(string $fqn) : string
    {
        if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($fqn, '\\')) {
            return $fqn;
        }
        /** @var string $lastNamePart */
        $lastNamePart = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($fqn, '\\', -1);
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($lastNamePart, self::INTERFACE)) {
            return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::substring($lastNamePart, 0, -\strlen(self::INTERFACE));
        }
        return $lastNamePart;
    }
    private function removeInterfaceSuffixPrefix(string $className, string $shortName) : string
    {
        // remove interface prefix/suffix
        if (!\interface_exists($className)) {
            return $shortName;
        }
        // starts with "I\W+"?
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($shortName, self::I_PREFIX_REGEX)) {
            return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::substring($shortName, 1);
        }
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($shortName, self::INTERFACE)) {
            return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::substring($shortName, -\strlen(self::INTERFACE));
        }
        return $shortName;
    }
    /**
     * @return ClassMethod[]
     */
    private function getPrefixedClassMethods(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : array
    {
        $classLike = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return [];
        }
        $classMethods = $this->betterNodeFinder->findInstanceOf($classLike, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class);
        return \array_filter($classMethods, function (\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool {
            $classMethodName = $this->nodeNameResolver->getName($classMethod);
            return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($classMethodName, self::PREFIXED_CLASS_METHODS_REGEX) !== null;
        });
    }
    /**
     * @param ClassMethod[] $prefixedClassMethods
     * @return ClassMethod[]
     */
    private function filterClassMethodsWithPropertyFetchReturnOnly(array $prefixedClassMethods, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : array
    {
        $currentName = $this->nodeNameResolver->getName($property);
        return \array_filter($prefixedClassMethods, function (\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) use($currentName) : bool {
            $stmts = $classMethod->stmts;
            if ($stmts === null) {
                return \false;
            }
            if (!\array_key_exists(0, $stmts)) {
                return \false;
            }
            $return = $stmts[0];
            if (!$return instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_) {
                return \false;
            }
            $node = $return->expr;
            if ($node === null) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, $currentName);
        });
    }
    private function isPrefixedInterface(string $shortClassName) : bool
    {
        if (\strlen($shortClassName) <= 3) {
            return \false;
        }
        if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::startsWith($shortClassName, 'I')) {
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
}
