<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Command;

interface Output
{
    public function writeFormatted(string $message) : void;
    public function writeLineFormatted(string $message) : void;
    public function writeRaw(string $message) : void;
    public function getStyle() : \_PhpScoperb75b35f52b74\PHPStan\Command\OutputStyle;
    public function isVerbose() : bool;
    public function isDebug() : bool;
}
