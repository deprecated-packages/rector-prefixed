<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertType;

use _PhpScoperbf340cb0be9d\Doctrine\Common\Collections\Collection;
use _PhpScoperbf340cb0be9d\Symfony\Component\Validator\Constraints as Assert;
class AssertType
{
    /**
     * @var Collection
     *
     * @Assert\Type(Collection::class)
     */
    protected $effectiveDatedMessages;
}
