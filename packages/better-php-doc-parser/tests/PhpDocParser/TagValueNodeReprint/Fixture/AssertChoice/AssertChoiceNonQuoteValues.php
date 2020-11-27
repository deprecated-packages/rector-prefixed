<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertChoice;

use _PhpScoper006a73f0e455\Symfony\Component\Validator\Constraints as Assert;
class AssertChoiceNonQuoteValues
{
    /**
     * @Assert\Choice({"chalet", "apartment"})
     */
    public $type;
}
