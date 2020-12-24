<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\PhpParser;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class FullyQualifiedNodeMapper implements \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified::class;
    }
    /**
     * @param FullyQualified $node
     */
    public function mapToPHPStan(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $originalName = (string) $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
        $fullyQualifiedName = $node->toString();
        // is aliased?
        if ($this->isAliasedName($originalName, $fullyQualifiedName)) {
            return new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\AliasedObjectType($originalName, $fullyQualifiedName);
        }
        return new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($fullyQualifiedName);
    }
    private function isAliasedName(string $originalName, string $fullyQualifiedName) : bool
    {
        if ($originalName === '') {
            return \false;
        }
        if ($originalName === $fullyQualifiedName) {
            return \false;
        }
        return !\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($fullyQualifiedName, '\\' . $originalName);
    }
}
