<?php

declare (strict_types=1);
namespace PHPStan\PhpDoc\TypeAlias;

use PHPStan\Analyser\NameScope;
use PHPStan\PhpDoc\TypeNodeResolverExtension;
use PHPStan\PhpDoc\TypeStringResolver;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Type;
use function array_key_exists;
class TypeAliasesTypeNodeResolverExtension implements \PHPStan\PhpDoc\TypeNodeResolverExtension
{
    /** @var TypeStringResolver */
    private $typeStringResolver;
    /** @var ReflectionProvider */
    private $reflectionProvider;
    /** @var array<string, string> */
    private $aliases;
    /** @var array<string, Type> */
    private $resolvedTypes = [];
    /** @var array<string, true> */
    private $inProcess = [];
    /**
     * @param TypeStringResolver $typeStringResolver
     * @param ReflectionProvider $reflectionProvider
     * @param array<string, string> $aliases
     */
    public function __construct(\PHPStan\PhpDoc\TypeStringResolver $typeStringResolver, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $aliases)
    {
        $this->typeStringResolver = $typeStringResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->aliases = $aliases;
    }
    public function resolve(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \PHPStan\Analyser\NameScope $nameScope) : ?\PHPStan\Type\Type
    {
        if ($typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $aliasName = $typeNode->name;
            if (\array_key_exists($aliasName, $this->resolvedTypes)) {
                return $this->resolvedTypes[$aliasName];
            }
            if (!\array_key_exists($aliasName, $this->aliases)) {
                return null;
            }
            if ($this->reflectionProvider->hasClass($aliasName)) {
                throw new \PHPStan\ShouldNotHappenException(\sprintf('Type alias %s already exists as a class.', $aliasName));
            }
            if (\array_key_exists($aliasName, $this->inProcess)) {
                throw new \PHPStan\ShouldNotHappenException(\sprintf('Circular definition for type alias %s.', $aliasName));
            }
            $this->inProcess[$aliasName] = \true;
            $aliasTypeString = $this->aliases[$aliasName];
            $aliasType = $this->typeStringResolver->resolve($aliasTypeString);
            $this->resolvedTypes[$aliasName] = $aliasType;
            unset($this->inProcess[$aliasName]);
            return $aliasType;
        }
        return null;
    }
}
