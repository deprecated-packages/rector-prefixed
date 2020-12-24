<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_;

use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
use _PhpScoper0a6b37af0871\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class ColumnTagValueNode extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \_PhpScoper0a6b37af0871\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
{
    public function changeType(string $type) : void
    {
        $this->items['type'] = $type;
    }
    public function getType() : ?string
    {
        return $this->items['type'];
    }
    public function isNullable() : ?bool
    {
        return $this->items['nullable'];
    }
    public function getShortName() : string
    {
        return '_PhpScoper0a6b37af0871\\@ORM\\Column';
    }
    /**
     * @return array<string, mixed>
     */
    public function getOptions() : array
    {
        return $this->items['options'] ?? [];
    }
    public function getAttributeClassName() : string
    {
        return 'TBA';
    }
}
