<?php

namespace _PhpScoper006a73f0e455\AnonymousClassName;

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
