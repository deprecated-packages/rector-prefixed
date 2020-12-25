<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertChoice;

use _PhpScoperbf340cb0be9d\Symfony\Component\Validator\Constraints as Assert;
class AssertChoiceWithCeroOnOptions
{
    /**
     * @Assert\Choice(choices={"0", "3023", "3610"})
     */
    public $ratingType;
}
