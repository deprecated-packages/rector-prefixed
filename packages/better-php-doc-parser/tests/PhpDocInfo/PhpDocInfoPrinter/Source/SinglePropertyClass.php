<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source;

use RectorPrefix20210204\Symfony\Component\Validator\Constraints as Assert;
final class SinglePropertyClass
{
    /**
     * @Assert\Type(
     *     "bool"
     * )
     */
    public $anotherSerializeSingleLine;
}
