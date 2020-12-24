<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeAlias;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverExtension;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeStringResolver;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use function array_key_exists;
class TypeAliasesTypeNodeResolverExtension implements \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverExtension
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
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeStringResolver $typeStringResolver, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $aliases)
    {
        $this->typeStringResolver = $typeStringResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->aliases = $aliases;
    }
    public function resolve(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            $aliasName = $typeNode->name;
            if (\array_key_exists($aliasName, $this->resolvedTypes)) {
                return $this->resolvedTypes[$aliasName];
            }
            if (!\array_key_exists($aliasName, $this->aliases)) {
                return null;
            }
            if ($this->reflectionProvider->hasClass($aliasName)) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException(\sprintf('Type alias %s already exists as a class.', $aliasName));
            }
            if (\array_key_exists($aliasName, $this->inProcess)) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException(\sprintf('Circular definition for type alias %s.', $aliasName));
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
