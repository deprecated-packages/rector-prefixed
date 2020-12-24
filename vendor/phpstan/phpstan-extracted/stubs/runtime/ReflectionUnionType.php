<?php

namespace _PhpScoper0a6b37af0871;

if (\PHP_VERSION_ID < 80000) {
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
}
