<?php

declare (strict_types=1);
namespace Rector\Doctrine\PhpDoc\Node;

use Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
abstract class AbstractDoctrineTagValueNode extends \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface, \Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface
{
}
