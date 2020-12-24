<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PHPStan;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\UseUse;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see https://github.com/phpstan/phpstan-src/blob/8376548f76e2c845ae047e3010e873015b796818/src/Analyser/NameScope.php#L32
 */
final class NameScopeFactory
{
    public function createNameScopeFromNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope
    {
        $namespace = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME);
        /** @var Use_[] $useNodes */
        $useNodes = (array) $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES);
        $uses = $this->resolveUseNamesByAlias($useNodes);
        $className = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\NameScope($namespace, $uses, $className);
    }
    /**
     * @param Use_[] $useNodes
     * @return array<string, string>
     */
    private function resolveUseNamesByAlias(array $useNodes) : array
    {
        $useNamesByAlias = [];
        foreach ($useNodes as $useNode) {
            foreach ($useNode->uses as $useUse) {
                /** @var UseUse $useUse */
                $aliasName = $useUse->getAlias()->name;
                $useName = $useUse->name->toString();
                if (!\is_string($useName)) {
                    throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
                }
                // uses must be lowercase, as PHPStan lowercases it
                $lowercasedAliasName = \strtolower($aliasName);
                $useNamesByAlias[$lowercasedAliasName] = $useName;
            }
        }
        return $useNamesByAlias;
    }
}
