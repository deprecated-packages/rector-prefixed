<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_;

use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
use _PhpScoperb75b35f52b74\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class EntityTagValueNode extends \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \_PhpScoperb75b35f52b74\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
{
    /**
     * @var string
     */
    private const REPOSITORY_CLASS = 'repositoryClass';
    public function removeRepositoryClass() : void
    {
        $this->items[self::REPOSITORY_CLASS] = null;
    }
    public function getShortName() : string
    {
        return '_PhpScoperb75b35f52b74\\@ORM\\Entity';
    }
    /**
     * @return mixed[]
     */
    public function getAttributableItems() : array
    {
        return $this->filterOutMissingItems($this->items);
    }
    public function getAttributeClassName() : string
    {
        return 'TBA';
    }
}
