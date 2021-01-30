<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Contract;

use PHPStan\PhpDocParser\Parser\PhpDocParser;
interface PhpDocParserAwareInterface
{
    public function setPhpDocParser(\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser) : void;
}
