<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
use _PhpScopere8e811afab72\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class EntityTagValueNode extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \_PhpScopere8e811afab72\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
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
        return '_PhpScopere8e811afab72\\@ORM\\Entity';
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
