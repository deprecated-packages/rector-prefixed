<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertType;

use RectorPrefix20201228\Symfony\Component\Validator\Constraints as Assert;
final class AssertStringQuotedType
{
    /**
     * @Assert\Type("string")
     */
    public $someStringProperty;
}
