<?php

namespace _PhpScoperabd03f0baf05\Bug3379;

class Foo
{
    const URL = SOME_UNKNOWN_CONST . '/test';
}
function () {
    echo \_PhpScoperabd03f0baf05\Bug3379\Foo::URL;
};
