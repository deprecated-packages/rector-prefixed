<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\Naming;

use PhpParser\Node;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;
use PHPStan\Analyser\NameScope;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see https://github.com/phpstan/phpstan-src/blob/8376548f76e2c845ae047e3010e873015b796818/src/Analyser/NameScope.php#L32
 */
final class NameScopeFactory
{
    public function createNameScopeFromNode(\PhpParser\Node $node) : \PHPStan\Analyser\NameScope
    {
        $namespace = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME);
        /** @var Use_[] $useNodes */
        $useNodes = (array) $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES);
        $uses = $this->resolveUseNamesByAlias($useNodes);
        $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return new \PHPStan\Analyser\NameScope($namespace, $uses, $className);
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
                    throw new \Rector\Core\Exception\ShouldNotHappenException();
                }
                // uses must be lowercase, as PHPStan lowercases it
                $lowercasedAliasName = \strtolower($aliasName);
                $useNamesByAlias[$lowercasedAliasName] = $useName;
            }
        }
        return $useNamesByAlias;
    }
}
