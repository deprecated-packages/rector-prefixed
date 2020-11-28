<?php

namespace _PhpScoperabd03f0baf05\CallableOrClosureProblem;

function call(callable $callable)
{
    if ($callable instanceof \Closure) {
    } elseif (\is_array($callable)) {
    }
    return \call_user_func_array($callable, []);
}
