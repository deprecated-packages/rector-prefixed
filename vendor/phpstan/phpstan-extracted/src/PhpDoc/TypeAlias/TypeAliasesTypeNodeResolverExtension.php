<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeAlias;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolverExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeStringResolver;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use function array_key_exists;
class TypeAliasesTypeNodeResolverExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolverExtension
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeStringResolver $typeStringResolver, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $aliases)
    {
        $this->typeStringResolver = $typeStringResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->aliases = $aliases;
    }
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($typeNode instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $aliasName = $typeNode->name;
            if (\array_key_exists($aliasName, $this->resolvedTypes)) {
                return $this->resolvedTypes[$aliasName];
            }
            if (!\array_key_exists($aliasName, $this->aliases)) {
                return null;
            }
            if ($this->reflectionProvider->hasClass($aliasName)) {
                throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException(\sprintf('Type alias %s already exists as a class.', $aliasName));
            }
            if (\array_key_exists($aliasName, $this->inProcess)) {
                throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException(\sprintf('Circular definition for type alias %s.', $aliasName));
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
