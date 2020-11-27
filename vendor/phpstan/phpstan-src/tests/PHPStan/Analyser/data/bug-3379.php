<?php

namespace _PhpScopera143bcca66cb\Bug3379;

class Foo
{
    const URL = SOME_UNKNOWN_CONST . '/test';
}
function () {
    echo \_PhpScopera143bcca66cb\Bug3379\Foo::URL;
};
