<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertChoice;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Validator\Constraints as Assert;
class AssertChoiceWithCeroOnOptions
{
    /**
     * @Assert\Choice(choices={"0", "3023", "3610"})
     */
    public $ratingType;
}
