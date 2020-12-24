<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Command;

interface Output
{
    public function writeFormatted(string $message) : void;
    public function writeLineFormatted(string $message) : void;
    public function writeRaw(string $message) : void;
    public function getStyle() : \_PhpScoper0a6b37af0871\PHPStan\Command\OutputStyle;
    public function isVerbose() : bool;
    public function isDebug() : bool;
}
