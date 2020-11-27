<?php

namespace _PhpScoperbd5d0c5f7638;

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
