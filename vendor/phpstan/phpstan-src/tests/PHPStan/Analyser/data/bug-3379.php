<?php

namespace _PhpScoper26e51eeacccf\Bug3379;

class Foo
{
    const URL = SOME_UNKNOWN_CONST . '/test';
}
function () {
    echo \_PhpScoper26e51eeacccf\Bug3379\Foo::URL;
};
