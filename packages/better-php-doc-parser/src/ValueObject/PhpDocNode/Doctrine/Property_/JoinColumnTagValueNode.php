<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_;

use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\TagAwareNodeInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
use _PhpScoperb75b35f52b74\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class JoinColumnTagValueNode extends \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\TagAwareNodeInterface, \_PhpScoperb75b35f52b74\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
{
    /**
     * @var string
     */
    private $shortName = '_PhpScoperb75b35f52b74\\@ORM\\JoinColumn';
    /**
     * @var string|null
     */
    private $tag;
    public function __construct(array $items, ?string $content = null, ?string $originalTag = null)
    {
        $this->tag = $originalTag;
        parent::__construct($items, $content);
    }
    public function isNullable() : ?bool
    {
        return $this->items['nullable'];
    }
    public function getTag() : string
    {
        return $this->tag ?: $this->shortName;
    }
    public function getUnique() : ?bool
    {
        return $this->items['unique'];
    }
    public function getShortName() : string
    {
        return $this->shortName;
    }
    public function changeShortName(string $shortName) : void
    {
        $this->shortName = $shortName;
    }
    public function getAttributeClassName() : string
    {
        return 'TBA';
    }
}
