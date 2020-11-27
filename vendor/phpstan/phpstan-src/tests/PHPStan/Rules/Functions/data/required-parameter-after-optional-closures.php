<?php

namespace _PhpScoper26e51eeacccf\RequiredAfterOptional;

function ($foo = null, $bar) : void {
};
function (int $foo = null, $bar) : void {
};
function (int $foo = 1, $bar) : void {
};
function (bool $foo = \true, $bar) : void {
};
