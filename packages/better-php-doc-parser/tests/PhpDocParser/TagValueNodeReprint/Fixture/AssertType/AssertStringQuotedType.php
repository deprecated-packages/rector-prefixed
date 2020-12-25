<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertType;

use _PhpScoper50d83356d739\Symfony\Component\Validator\Constraints as Assert;
final class AssertStringQuotedType
{
    /**
     * @Assert\Type("string")
     */
    public $someStringProperty;
}
