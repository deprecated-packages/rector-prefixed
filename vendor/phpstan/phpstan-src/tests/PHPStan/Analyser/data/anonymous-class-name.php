<?php

namespace _PhpScopera143bcca66cb\AnonymousClassName;

function () {
    $foo = new class
    {
        /** @var Foo */
        public $fooProperty;
        /**
         * @return Foo
         */
        public function doFoo()
        {
            'inside';
        }
    };
    'outside';
};
