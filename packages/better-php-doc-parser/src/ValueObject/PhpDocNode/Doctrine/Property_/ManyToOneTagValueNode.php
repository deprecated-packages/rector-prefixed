<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_;

use Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface;
use Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
final class ManyToOneTagValueNode extends \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface, \Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface
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
        return '_PhpScoper8b9c402c5f32\\@ORM\\ManyToOne';
    }
}
