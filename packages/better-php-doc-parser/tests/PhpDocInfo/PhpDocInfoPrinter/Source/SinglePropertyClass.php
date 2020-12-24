<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source;

use _PhpScopere8e811afab72\Symfony\Component\Validator\Constraints as Assert;
final class SinglePropertyClass
{
    /**
     * @Assert\Type(
     *     "bool"
     * )
     */
    public $anotherSerializeSingleLine;
}
