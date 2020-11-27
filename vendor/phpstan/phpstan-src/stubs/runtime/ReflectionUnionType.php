<?php

namespace _PhpScoper88fe6e0ad041;

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
