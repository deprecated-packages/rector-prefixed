<?php

namespace _PhpScoper26e51eeacccf;

class SplTempFileObject extends \SplFileObject
{
    public function __construct(int $maxMemory = 2 * 1024 * 1024)
    {
    }
}
\class_alias('_PhpScoper26e51eeacccf\\SplTempFileObject', 'SplTempFileObject', \false);
