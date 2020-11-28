<?php

namespace _PhpScoperabd03f0baf05\AnonymousClassName;

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
