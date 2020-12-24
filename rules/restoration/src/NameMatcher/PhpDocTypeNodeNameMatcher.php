<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Restoration\NameMatcher;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode;
final class PhpDocTypeNodeNameMatcher
{
    /**
     * @var NameMatcher
     */
    private $nameMatcher;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Restoration\NameMatcher\NameMatcher $nameMatcher)
    {
        $this->nameMatcher = $nameMatcher;
    }
    public function matchIdentifier(string $name) : ?\_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $name = \ltrim($name, '\\');
        $fullyQualified = $this->nameMatcher->makeNameFullyQualified($name);
        if ($fullyQualified === null) {
            return null;
        }
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode($fullyQualified);
    }
}
