<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertChoice;

use RectorPrefix20210308\Symfony\Component\Validator\Constraints as Assert;
class AssertChoiceNonQuoteValues
{
    /**
     * @Assert\Choice({"chalet", "apartment"})
     */
    public $type;
}
