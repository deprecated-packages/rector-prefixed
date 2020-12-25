<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertChoice;

use _PhpScoper8b9c402c5f32\Symfony\Component\Validator\Constraints as Assert;
class AssertChoice
{
    public const RATINGS_DISCRIMINATOR_MAP = ['5star' => '_PhpScoper8b9c402c5f32\\App\\Entity\\Rating\\FiveStar', '4star' => '_PhpScoper8b9c402c5f32\\App\\Entity\\Rating\\FourStar'];
    public const SMALL_ONE = 'small_one';
    /**
     * @Assert\Choice(choices=AssertChoice::RATINGS_DISCRIMINATOR_MAP, groups={AssertChoice::SMALL_ONE})
     */
    private $ratingType;
}
