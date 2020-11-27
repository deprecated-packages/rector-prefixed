<?php

namespace _PhpScoper88fe6e0ad041\Bug3379;

class Foo
{
    const URL = SOME_UNKNOWN_CONST . '/test';
}
function () {
    echo \_PhpScoper88fe6e0ad041\Bug3379\Foo::URL;
};
