<?php

namespace _PhpScoperbf340cb0be9d;

if (\PHP_VERSION_ID < 80000) {
    interface Stringable
    {
        /**
         * @return string
         */
        public function __toString();
    }
}
