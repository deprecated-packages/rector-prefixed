<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertChoice;

use _PhpScoperb75b35f52b74\Symfony\Component\Validator\Constraints as Assert;
class AssertQuoteChoice
{
    const CHOICE_ONE = 'choice_one';
    const CHOICE_TWO = 'choice_two';
    /**
     * @Assert\Choice({AssertQuoteChoice::CHOICE_ONE, AssertQuoteChoice::CHOICE_TWO})
     */
    private $someChoice = self::CHOICE_ONE;
}
