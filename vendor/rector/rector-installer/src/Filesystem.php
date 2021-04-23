<?php

declare (strict_types=1);
namespace Rector\RectorInstaller;

interface Filesystem
{
    /**
     * @param string $pathToFile
     */
    public function isFile($pathToFile) : bool;
    /**
     * @param string $pathToFile
     */
    public function hashFile($pathToFile) : string;
    /**
     * @param string $hash
     * @param string $content
     */
    public function hashEquals($hash, $content) : bool;
    /**
     * @return void
     * @param string $pathToFile
     * @param string $contents
     */
    public function writeFile($pathToFile, $contents);
}
