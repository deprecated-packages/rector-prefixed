<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
use _PhpScopere8e811afab72\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
use _PhpScopere8e811afab72\Symfony\Component\Routing\Annotation\Route;
/**
 * @see \Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\TagValueNodeReprintTest
 */
final class SymfonyRouteTagValueNode extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface, \_PhpScopere8e811afab72\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
{
    /**
     * @var string
     */
    public const CLASS_NAME = \_PhpScopere8e811afab72\Symfony\Component\Routing\Annotation\Route::class;
    /**
     * @var string
     */
    private const PATH = 'path';
    public function __toString() : string
    {
        $items = $this->items;
        if (isset($items[self::PATH]) || isset($items['localizedPaths'])) {
            $items[self::PATH] = $items[self::PATH] ?? $this->items['localizedPaths'];
        }
        return $this->printItems($items);
    }
    /**
     * @param string[] $methods
     */
    public function changeMethods(array $methods) : void
    {
        $this->tagValueNodeConfiguration->addOrderedVisibleItem('methods');
        $this->items['methods'] = $methods;
    }
    public function getSilentKey() : string
    {
        return self::PATH;
    }
    public function getShortName() : string
    {
        return '@Route';
    }
    public function mimicTagValueNodeConfiguration(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode $abstractTagValueNode) : void
    {
        $this->tagValueNodeConfiguration->mimic($abstractTagValueNode->tagValueNodeConfiguration);
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
        return '_PhpScopere8e811afab72\\Symfony\\Component\\Routing\\Annotation\\Route';
    }
}
