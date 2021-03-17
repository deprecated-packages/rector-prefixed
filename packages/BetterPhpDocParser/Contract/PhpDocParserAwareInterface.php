<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Contract;

use PHPStan\PhpDocParser\Parser\PhpDocParser;
interface PhpDocParserAwareInterface
{
    /**
     * @param \PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser
     */
    public function setPhpDocParser($phpDocParser) : void;
}
