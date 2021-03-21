<?php

declare (strict_types=1);
namespace Rector\Symfony\PhpDoc\Node\JMS;

use Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
/**
 * @see https://jmsyst.com/bundles/JMSDiExtraBundle/master/annotations#service
 */
final class JMSServiceTagValueNode extends \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface
{
    public function getShortName() : string
    {
        return '@DI\\Service';
    }
}
