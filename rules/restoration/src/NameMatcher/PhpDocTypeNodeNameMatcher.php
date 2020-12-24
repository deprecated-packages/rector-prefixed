<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Restoration\NameMatcher;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode;
final class PhpDocTypeNodeNameMatcher
{
    /**
     * @var NameMatcher
     */
    private $nameMatcher;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Restoration\NameMatcher\NameMatcher $nameMatcher)
    {
        $this->nameMatcher = $nameMatcher;
    }
    public function matchIdentifier(string $name) : ?\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $name = \ltrim($name, '\\');
        $fullyQualified = $this->nameMatcher->makeNameFullyQualified($name);
        if ($fullyQualified === null) {
            return null;
        }
        return new \_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\Type\FullyQualifiedIdentifierTypeNode($fullyQualified);
    }
}
