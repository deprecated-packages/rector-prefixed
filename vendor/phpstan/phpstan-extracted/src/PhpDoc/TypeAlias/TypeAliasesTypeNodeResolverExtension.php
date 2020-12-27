<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc\TypeAlias;

use RectorPrefix20201227\PHPStan\Analyser\NameScope;
use RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverExtension;
use RectorPrefix20201227\PHPStan\PhpDoc\TypeStringResolver;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Type;
use function array_key_exists;
class TypeAliasesTypeNodeResolverExtension implements \RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverExtension
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
    public function __construct(\RectorPrefix20201227\PHPStan\PhpDoc\TypeStringResolver $typeStringResolver, \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $aliases)
    {
        $this->typeStringResolver = $typeStringResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->aliases = $aliases;
    }
    public function resolve(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \RectorPrefix20201227\PHPStan\Analyser\NameScope $nameScope) : ?\PHPStan\Type\Type
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
                throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException(\sprintf('Type alias %s already exists as a class.', $aliasName));
            }
            if (\array_key_exists($aliasName, $this->inProcess)) {
                throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException(\sprintf('Circular definition for type alias %s.', $aliasName));
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
