<?php

namespace _PhpScopera143bcca66cb;

class SplTempFileObject extends \SplFileObject
{
    public function __construct(int $maxMemory = 2 * 1024 * 1024)
    {
    }
}
\class_alias('_PhpScopera143bcca66cb\\SplTempFileObject', 'SplTempFileObject', \false);
