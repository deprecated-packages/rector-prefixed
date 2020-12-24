<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\NameMatcher;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode;
final class PhpDocTypeNodeNameMatcher
{
    /**
     * @var NameMatcher
     */
    private $nameMatcher;
    public function __construct(\_PhpScopere8e811afab72\Rector\Restoration\NameMatcher\NameMatcher $nameMatcher)
    {
        $this->nameMatcher = $nameMatcher;
    }
    public function matchIdentifier(string $name) : ?\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $name = \ltrim($name, '\\');
        $fullyQualified = $this->nameMatcher->makeNameFullyQualified($name);
        if ($fullyQualified === null) {
            return null;
        }
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode($fullyQualified);
    }
}
