<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_;

use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\TagAwareNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
final class IndexTagValueNode extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\TagAwareNodeInterface
{
    /**
     * @var string|null
     */
    private $tag;
    public function __construct(array $items, ?string $content = null, ?string $originalTag = null)
    {
        $this->tag = $originalTag;
        parent::__construct($items, $content);
    }
    public function getTag() : string
    {
        return $this->tag ?: $this->getShortName();
    }
    public function getShortName() : string
    {
        return '_PhpScoper0a6b37af0871\\@ORM\\Index';
    }
}
