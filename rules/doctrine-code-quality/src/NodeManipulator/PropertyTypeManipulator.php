<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineCodeQuality\NodeManipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class PropertyTypeManipulator
{
    /**
     * @var DocBlockClassRenamer
     */
    private $docBlockClassRenamer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockClassRenamer $docBlockClassRenamer)
    {
        $this->docBlockClassRenamer = $docBlockClassRenamer;
    }
    public function changePropertyType(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property, string $oldClass, string $newClass) : void
    {
        if ($property->type !== null) {
            // fix later
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException();
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return;
        }
        $this->docBlockClassRenamer->renamePhpDocType($phpDocInfo->getPhpDocNode(), new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($oldClass), new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($newClass), $property);
    }
}
