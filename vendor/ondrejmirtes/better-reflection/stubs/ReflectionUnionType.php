<?php

namespace _PhpScoper26e51eeacccf;

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
\class_alias('_PhpScoper26e51eeacccf\\ReflectionUnionType', 'ReflectionUnionType', \false);
