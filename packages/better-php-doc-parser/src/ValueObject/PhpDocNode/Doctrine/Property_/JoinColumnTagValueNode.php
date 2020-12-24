<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_;

use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\TagAwareNodeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class JoinColumnTagValueNode extends \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\PhpDocNode\TagAwareNodeInterface, \_PhpScoper2a4e7ab1ecbc\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
{
    /**
     * @var string
     */
    private $shortName = '_PhpScoper2a4e7ab1ecbc\\@ORM\\JoinColumn';
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
