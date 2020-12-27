<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

interface ReflectionWithFilename
{
    /**
     * @return string|false
     */
    public function getFileName();
}
