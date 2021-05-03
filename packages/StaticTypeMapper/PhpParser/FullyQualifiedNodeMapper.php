<?php

declare (strict_types=1);
namespace Rector\StaticTypeMapper\PhpParser;

use RectorPrefix20210503\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
use Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class FullyQualifiedNodeMapper implements \Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    /**
     * @return class-string<Node>
     */
    public function getNodeType() : string
    {
        return \PhpParser\Node\Name\FullyQualified::class;
    }
    /**
     * @param FullyQualified $node
     */
    public function mapToPHPStan(\PhpParser\Node $node) : \PHPStan\Type\Type
    {
        $originalName = (string) $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
        $fullyQualifiedName = $node->toString();
        // is aliased?
        if ($this->isAliasedName($originalName, $fullyQualifiedName)) {
            return new \Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType($originalName, $fullyQualifiedName);
        }
        return new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($fullyQualifiedName);
    }
    private function isAliasedName(string $originalName, string $fullyQualifiedName) : bool
    {
        if ($originalName === '') {
            return \false;
        }
        if ($originalName === $fullyQualifiedName) {
            return \false;
        }
        return !\RectorPrefix20210503\Nette\Utils\Strings::endsWith($fullyQualifiedName, '\\' . $originalName);
    }
}
