<?php

namespace _PhpScoper26e51eeacccf\AnonymousClassName;

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
