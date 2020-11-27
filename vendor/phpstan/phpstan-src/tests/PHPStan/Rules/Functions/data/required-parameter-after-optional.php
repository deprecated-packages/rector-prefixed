<?php

namespace _PhpScoper88fe6e0ad041\RequiredAfterOptional;

function doFoo($foo = null, $bar) : void
{
}
function doBar(int $foo = null, $bar) : void
{
}
function doBaz(int $foo = 1, $bar) : void
{
}
function doLorem(bool $foo = \true, $bar) : void
{
}
function doIpsum(bool $foo = \true, ...$bar) : void
{
}
