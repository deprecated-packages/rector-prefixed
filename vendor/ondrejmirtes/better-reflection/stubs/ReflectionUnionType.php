<?php

namespace _PhpScoper88fe6e0ad041;

if (\class_exists('ReflectionUnionType', \false)) {
    return;
}
class ReflectionUnionType extends \ReflectionType
{
    /** @return ReflectionType[] */
    public function getTypes()
    {
        return [];
    }
}
\class_alias('_PhpScoper88fe6e0ad041\\ReflectionUnionType', 'ReflectionUnionType', \false);
