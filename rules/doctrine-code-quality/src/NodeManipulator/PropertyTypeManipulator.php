<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DoctrineCodeQuality\NodeManipulator;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class PropertyTypeManipulator
{
    /**
     * @var DocBlockClassRenamer
     */
    private $docBlockClassRenamer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer $docBlockClassRenamer)
    {
        $this->docBlockClassRenamer = $docBlockClassRenamer;
    }
    public function changePropertyType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property, string $oldClass, string $newClass) : void
    {
        if ($property->type !== null) {
            // fix later
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\NotImplementedYetException();
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $this->docBlockClassRenamer->renamePhpDocType($phpDocInfo->getPhpDocNode(), new \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($oldClass), new \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($newClass), $property);
    }
}
