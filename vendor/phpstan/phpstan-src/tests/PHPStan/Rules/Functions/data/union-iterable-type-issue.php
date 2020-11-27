<?php

namespace _PhpScoper006a73f0e455\UnionIterableTypeIssue;

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
