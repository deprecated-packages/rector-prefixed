<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DoctrineCodeQuality\NodeManipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class PropertyTypeManipulator
{
    /**
     * @var DocBlockClassRenamer
     */
    private $docBlockClassRenamer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer $docBlockClassRenamer)
    {
        $this->docBlockClassRenamer = $docBlockClassRenamer;
    }
    public function changePropertyType(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, string $oldClass, string $newClass) : void
    {
        if ($property->type !== null) {
            // fix later
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\NotImplementedYetException();
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $this->docBlockClassRenamer->renamePhpDocType($phpDocInfo->getPhpDocNode(), new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($oldClass), new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType($newClass), $property);
    }
}
