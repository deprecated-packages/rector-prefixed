<?php

namespace _PhpScoper88fe6e0ad041\AnonymousClassName;

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
