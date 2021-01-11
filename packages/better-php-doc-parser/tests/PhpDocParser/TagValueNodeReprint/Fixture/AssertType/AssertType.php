<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertType;

use RectorPrefix20210111\Doctrine\Common\Collections\Collection;
use RectorPrefix20210111\Symfony\Component\Validator\Constraints as Assert;
class AssertType
{
    /**
     * @var Collection
     *
     * @Assert\Type(Collection::class)
     */
    protected $effectiveDatedMessages;
}
