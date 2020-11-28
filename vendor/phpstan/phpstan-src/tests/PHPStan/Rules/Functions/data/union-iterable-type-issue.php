<?php

namespace _PhpScoperabd03f0baf05\UnionIterableTypeIssue;

/**
 * @param int|mixed[]|null $var
 */
function foo($var)
{
}
/**
 * @param int|null $var
 */
function bar($var)
{
    foo($var);
}
