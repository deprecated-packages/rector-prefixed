<?php

namespace _PhpScoperb75b35f52b74;

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
