<?php

declare (strict_types=1);
namespace PHPStan\PhpDocParser\Ast\PhpDoc;

use PHPStan\PhpDocParser\Ast\NodeAttributes;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
class TypeAliasImportTagValueNode implements \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var string */
    public $importedAlias;
    /** @var IdentifierTypeNode */
    public $importedFrom;
    /** @var string|null */
    public $importedAs;
    /**
     * @param string|null $importedAs
     */
    public function __construct(string $importedAlias, \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $importedFrom, $importedAs)
    {
        $this->importedAlias = $importedAlias;
        $this->importedFrom = $importedFrom;
        $this->importedAs = $importedAs;
    }
    public function __toString() : string
    {
        return \trim("{$this->importedAlias} from {$this->importedFrom}" . ($this->importedAs !== null ? " as {$this->importedAs}" : ''));
    }
}
