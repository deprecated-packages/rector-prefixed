<?php

namespace _PhpScoper006a73f0e455\Bug3379;

class Foo
{
    const URL = SOME_UNKNOWN_CONST . '/test';
}
function () {
    echo \_PhpScoper006a73f0e455\Bug3379\Foo::URL;
};
