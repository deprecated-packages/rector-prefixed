<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Command;

interface Output
{
    public function writeFormatted(string $message) : void;
    public function writeLineFormatted(string $message) : void;
    public function writeRaw(string $message) : void;
    public function getStyle() : \RectorPrefix20201227\PHPStan\Command\OutputStyle;
    public function isVerbose() : bool;
    public function isDebug() : bool;
}
