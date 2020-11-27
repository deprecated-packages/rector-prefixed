<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\ReflectionUnionType', 'ReflectionUnionType', \false);
