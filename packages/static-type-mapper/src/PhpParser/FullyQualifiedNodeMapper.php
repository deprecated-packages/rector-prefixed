<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\PhpParser;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class FullyQualifiedNodeMapper implements \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified::class;
    }
    /**
     * @param FullyQualified $node
     */
    public function mapToPHPStan(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $originalName = (string) $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
        $fullyQualifiedName = $node->toString();
        // is aliased?
        if ($this->isAliasedName($originalName, $fullyQualifiedName)) {
            return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\AliasedObjectType($originalName, $fullyQualifiedName);
        }
        return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($fullyQualifiedName);
    }
    private function isAliasedName(string $originalName, string $fullyQualifiedName) : bool
    {
        if ($originalName === '') {
            return \false;
        }
        if ($originalName === $fullyQualifiedName) {
            return \false;
        }
        return !\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($fullyQualifiedName, '\\' . $originalName);
    }
}
