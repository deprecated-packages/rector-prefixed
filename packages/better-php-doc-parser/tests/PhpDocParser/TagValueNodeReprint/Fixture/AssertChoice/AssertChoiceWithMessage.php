<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertChoice;

use _PhpScoper0a2ac50786fa\Symfony\Component\Validator\Constraints as Assert;
class AssertChoiceWithMessage
{
    /**
     * @Assert\Choice(callback={"App\Entity\Genre", "getGenres"}, message="The value you selected is not a valid choice. Please one of {{ choices }}")
     */
    private $ratingType;
}
