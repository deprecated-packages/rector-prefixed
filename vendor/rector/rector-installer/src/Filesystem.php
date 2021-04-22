<?php

declare (strict_types=1);
namespace Rector\RectorInstaller;

interface Filesystem
{
    public function isFile(string $pathToFile) : bool;
    public function hashFile(string $pathToFile) : string;
    public function hashEquals(string $hash, string $content) : bool;
    /**
     * @return void
     */
    public function writeFile(string $pathToFile, string $contents);
}
