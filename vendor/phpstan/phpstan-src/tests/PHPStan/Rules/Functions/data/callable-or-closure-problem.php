<?php

namespace _PhpScoperbd5d0c5f7638\CallableOrClosureProblem;

function call(callable $callable)
{
    if ($callable instanceof \Closure) {
    } elseif (\is_array($callable)) {
    }
    return \call_user_func_array($callable, []);
}
