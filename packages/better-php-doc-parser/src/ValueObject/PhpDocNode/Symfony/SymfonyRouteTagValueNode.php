<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony;

use Rector\BetterPhpDocParser\Contract\PhpDocNode\ClassNameAwareTagInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
use Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
use RectorPrefix20210211\Symfony\Component\Routing\Annotation\Route;
/**
 * @see \Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\TagValueNodeReprintTest
 */
final class SymfonyRouteTagValueNode extends \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface, \Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface, \Rector\BetterPhpDocParser\Contract\PhpDocNode\ClassNameAwareTagInterface
{
    /**
     * @var string
     */
    public const CLASS_NAME = \RectorPrefix20210211\Symfony\Component\Routing\Annotation\Route::class;
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
    public function mimicTagValueNodeConfiguration(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode $abstractTagValueNode) : void
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
        return self::CLASS_NAME;
    }
    public function getClassName() : string
    {
        return self::CLASS_NAME;
    }
}
