<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
final class ManyToOneTagValueNode extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface
{
    /**
     * @var string
     */
    private $fullyQualifiedTargetEntity;
    public function __construct(array $items, ?string $content, string $fullyQualifiedTargetEntity)
    {
        $this->fullyQualifiedTargetEntity = $fullyQualifiedTargetEntity;
        parent::__construct($items, $content);
    }
    public function getTargetEntity() : ?string
    {
        return $this->items['targetEntity'];
    }
    public function getFullyQualifiedTargetEntity() : string
    {
        return $this->fullyQualifiedTargetEntity;
    }
    public function getInversedBy() : ?string
    {
        return $this->items['inversedBy'];
    }
    public function removeInversedBy() : void
    {
        $this->items['inversedBy'] = null;
    }
    public function changeTargetEntity(string $targetEntity) : void
    {
        $this->items['targetEntity'] = $targetEntity;
    }
    public function getShortName() : string
    {
        return '_PhpScopere8e811afab72\\@ORM\\ManyToOne';
    }
}
