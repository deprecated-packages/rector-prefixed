<?php

declare(strict_types=1);

namespace Rector\Doctrine\NodeManipulator;

use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Core\Exception\NotImplementedYetException;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer;
use Rector\NodeTypeResolver\ValueObject\OldToNewType;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;

final class PropertyTypeManipulator
{
    /**
     * @var DocBlockClassRenamer
     */
    private $docBlockClassRenamer;

    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;

    public function __construct(DocBlockClassRenamer $docBlockClassRenamer, PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->docBlockClassRenamer = $docBlockClassRenamer;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }

    /**
     * @return void
     */
    public function changePropertyType(Property $property, string $oldClass, string $newClass)
    {
        if ($property->type !== null) {
            // fix later
            throw new NotImplementedYetException();
        }

        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);

        $oldToNewTypes = [
            new OldToNewType(new FullyQualifiedObjectType($oldClass), new FullyQualifiedObjectType($newClass)),
        ];
        $this->docBlockClassRenamer->renamePhpDocType($phpDocInfo, $oldToNewTypes);

        if ($phpDocInfo->hasChanged()) {
            // invoke phpdoc reprint
            $property->setAttribute(AttributeKey::ORIGINAL_NODE, null);
        }
    }
}
