<?php

namespace _PhpScoperabd03f0baf05;

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
\class_alias('_PhpScoperabd03f0baf05\\ReflectionUnionType', 'ReflectionUnionType', \false);
