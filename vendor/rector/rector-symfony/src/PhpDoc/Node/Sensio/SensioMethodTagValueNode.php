<?php

declare (strict_types=1);
namespace Rector\Symfony\PhpDoc\Node\Sensio;

use Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
/**
 * @see https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/routing.html
 */
final class SensioMethodTagValueNode extends \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    /**
     * @return string[]
     */
    public function getMethods() : array
    {
        return $this->items['methods'];
    }
    public function getShortName() : string
    {
        return '@Method';
    }
    public function getSilentKey() : string
    {
        return 'methods';
    }
}
