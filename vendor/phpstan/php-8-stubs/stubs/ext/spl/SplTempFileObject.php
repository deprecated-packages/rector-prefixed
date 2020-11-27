<?php

namespace _PhpScoperbd5d0c5f7638;

class SplTempFileObject extends \SplFileObject
{
    public function __construct(int $maxMemory = 2 * 1024 * 1024)
    {
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\SplTempFileObject', 'SplTempFileObject', \false);
