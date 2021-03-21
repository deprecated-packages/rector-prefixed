<?php

declare (strict_types=1);
namespace Rector\Symfony\PhpDoc\Node;

use Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
/**
 * @see \Rector\Tests\BetterPhpDocParser\PhpDocParser\TagValueNodeReprint\TagValueNodeReprintTest
 */
final class AssertChoiceTagValueNode extends \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    public function isCallbackClass(string $class) : bool
    {
        return $class === ($this->items['callback'][0] ?? null);
    }
    public function changeCallbackClass(string $newClass) : void
    {
        $this->items['callback'][0] = $newClass;
    }
    public function getShortName() : string
    {
        return 'RectorPrefix20210321\\@Assert\\Choice';
    }
    public function getSilentKey() : string
    {
        return 'choices';
    }
}
