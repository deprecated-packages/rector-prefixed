<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertChoice;

use RectorPrefix20210305\Symfony\Component\Validator\Constraints as Assert;
class AssertChoiceQuoteValues
{
    /**
     * @Assert\Choice({"chalet", "apartment"})
     */
    public $type;
}
