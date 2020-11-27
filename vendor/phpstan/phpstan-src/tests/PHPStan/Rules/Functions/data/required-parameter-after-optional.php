<?php

namespace _PhpScoper26e51eeacccf\RequiredAfterOptional;

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
