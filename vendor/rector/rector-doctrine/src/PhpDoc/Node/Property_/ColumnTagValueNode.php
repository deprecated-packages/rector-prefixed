<?php

declare (strict_types=1);
namespace Rector\Doctrine\PhpDoc\Node\Property_;

use Rector\Doctrine\PhpDoc\Node\AbstractDoctrineTagValueNode;
final class ColumnTagValueNode extends \Rector\Doctrine\PhpDoc\Node\AbstractDoctrineTagValueNode
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
        return '@ORM\\Column';
    }
    /**
     * @return array<string, mixed>
     */
    public function getOptions() : array
    {
        return $this->items['options'] ?? [];
    }
}
