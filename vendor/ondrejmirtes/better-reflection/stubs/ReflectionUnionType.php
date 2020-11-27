<?php

namespace _PhpScopera143bcca66cb;

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
\class_alias('_PhpScopera143bcca66cb\\ReflectionUnionType', 'ReflectionUnionType', \false);
