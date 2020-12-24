<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertChoice;

use _PhpScopere8e811afab72\Symfony\Component\Validator\Constraints as Assert;
class AssertChoice
{
    public const RATINGS_DISCRIMINATOR_MAP = ['5star' => '_PhpScopere8e811afab72\\App\\Entity\\Rating\\FiveStar', '4star' => '_PhpScopere8e811afab72\\App\\Entity\\Rating\\FourStar'];
    public const SMALL_ONE = 'small_one';
    /**
     * @Assert\Choice(choices=AssertChoice::RATINGS_DISCRIMINATOR_MAP, groups={AssertChoice::SMALL_ONE})
     */
    private $ratingType;
}
