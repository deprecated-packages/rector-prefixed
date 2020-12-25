<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertChoice;

use _PhpScoperbf340cb0be9d\Symfony\Component\Validator\Constraints as Assert;
class AssertChoice
{
    public const RATINGS_DISCRIMINATOR_MAP = ['5star' => '_PhpScoperbf340cb0be9d\\App\\Entity\\Rating\\FiveStar', '4star' => '_PhpScoperbf340cb0be9d\\App\\Entity\\Rating\\FourStar'];
    public const SMALL_ONE = 'small_one';
    /**
     * @Assert\Choice(choices=AssertChoice::RATINGS_DISCRIMINATOR_MAP, groups={AssertChoice::SMALL_ONE})
     */
    private $ratingType;
}
