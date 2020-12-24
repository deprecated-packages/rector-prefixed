<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\StaticTypeMapper\PhpParser;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface;
final class FullyQualifiedNodeMapper implements \_PhpScopere8e811afab72\Rector\StaticTypeMapper\Contract\PhpParser\PhpParserNodeMapperInterface
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified::class;
    }
    /**
     * @param FullyQualified $node
     */
    public function mapToPHPStan(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $originalName = (string) $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
        $fullyQualifiedName = $node->toString();
        // is aliased?
        if ($this->isAliasedName($originalName, $fullyQualifiedName)) {
            return new \_PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType($originalName, $fullyQualifiedName);
        }
        return new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($fullyQualifiedName);
    }
    private function isAliasedName(string $originalName, string $fullyQualifiedName) : bool
    {
        if ($originalName === '') {
            return \false;
        }
        if ($originalName === $fullyQualifiedName) {
            return \false;
        }
        return !\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($fullyQualifiedName, '\\' . $originalName);
    }
}
