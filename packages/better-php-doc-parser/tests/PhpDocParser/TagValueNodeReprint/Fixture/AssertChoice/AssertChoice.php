<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertChoice;

use RectorPrefix2020DecSat\Symfony\Component\Validator\Constraints as Assert;
class AssertChoice
{
    public const RATINGS_DISCRIMINATOR_MAP = ['5star' => 'RectorPrefix2020DecSat\\App\\Entity\\Rating\\FiveStar', '4star' => 'RectorPrefix2020DecSat\\App\\Entity\\Rating\\FourStar'];
    public const SMALL_ONE = 'small_one';
    /**
     * @Assert\Choice(choices=AssertChoice::RATINGS_DISCRIMINATOR_MAP, groups={AssertChoice::SMALL_ONE})
     */
    private $ratingType;
}
