<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\TagAwareNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
final class IndexTagValueNode extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\TagAwareNodeInterface
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
        return '_PhpScopere8e811afab72\\@ORM\\Index';
    }
}
