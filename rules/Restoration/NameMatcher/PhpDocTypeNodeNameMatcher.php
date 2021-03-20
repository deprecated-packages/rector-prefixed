<?php

declare (strict_types=1);
namespace Rector\Restoration\NameMatcher;

use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use Rector\BetterPhpDocParser\ValueObject\Type\FullyQualifiedIdentifierTypeNode;
final class PhpDocTypeNodeNameMatcher
{
    /**
     * @var NameMatcher
     */
    private $nameMatcher;
    public function __construct(\Rector\Restoration\NameMatcher\NameMatcher $nameMatcher)
    {
        $this->nameMatcher = $nameMatcher;
    }
    public function matchIdentifier(string $name) : ?\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $name = \ltrim($name, '\\');
        $fullyQualified = $this->nameMatcher->makeNameFullyQualified($name);
        if ($fullyQualified === null) {
            return null;
        }
        return new \Rector\BetterPhpDocParser\ValueObject\Type\FullyQualifiedIdentifierTypeNode($fullyQualified);
    }
}
