<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_;

use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
final class OneToOneTagValueNode extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface
{
    /**
     * @var string|null
     */
    private $fullyQualifiedTargetEntity;
    public function __construct(array $items, ?string $content = null, ?string $fullyQualifiedTargetEntity = null)
    {
        $this->fullyQualifiedTargetEntity = $fullyQualifiedTargetEntity;
        parent::__construct($items, $content);
    }
    public function getTargetEntity() : ?string
    {
        return $this->items['targetEntity'];
    }
    public function getFullyQualifiedTargetEntity() : ?string
    {
        return $this->fullyQualifiedTargetEntity;
    }
    public function getInversedBy() : ?string
    {
        return $this->items['inversedBy'];
    }
    public function getMappedBy() : ?string
    {
        return $this->items['mappedBy'];
    }
    public function removeInversedBy() : void
    {
        $this->items['inversedBy'] = null;
    }
    public function removeMappedBy() : void
    {
        $this->items['mappedBy'] = null;
    }
    public function changeTargetEntity(string $targetEntity) : void
    {
        $this->items['targetEntity'] = $targetEntity;
    }
    public function getShortName() : string
    {
        return '_PhpScoper0a6b37af0871\\@ORM\\OneToOne';
    }
}
