<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\AssertType;

use _PhpScopere8e811afab72\Symfony\Component\Validator\Constraints as Assert;
final class AssertTypeWithMessage
{
    /**
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     */
    protected $age;
}
