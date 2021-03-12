<?php

declare (strict_types=1);
namespace Rector\DoctrineCodeQuality\NodeManipulator;

use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Core\Exception\NotImplementedYetException;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer;
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
    public function __construct(\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer $docBlockClassRenamer, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->docBlockClassRenamer = $docBlockClassRenamer;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function changePropertyType(\PhpParser\Node\Stmt\Property $property, string $oldClass, string $newClass) : void
    {
        if ($property->type !== null) {
            // fix later
            throw new \Rector\Core\Exception\NotImplementedYetException();
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $this->docBlockClassRenamer->renamePhpDocType($phpDocInfo, new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($oldClass), new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($newClass), $property);
    }
}
