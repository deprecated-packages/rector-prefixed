<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertType;

use _PhpScoper26e51eeacccf\Symfony\Component\Validator\Constraints as Assert;
final class AssertStringType
{
    /**
     * @Assert\Type("string")
     */
    public $anotherProperty;
}
