<?php

namespace _PhpScoperbd5d0c5f7638\Bug3379;

class Foo
{
    const URL = SOME_UNKNOWN_CONST . '/test';
}
function () {
    echo \_PhpScoperbd5d0c5f7638\Bug3379\Foo::URL;
};
