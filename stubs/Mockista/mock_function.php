<?php

namespace _PhpScopera143bcca66cb;

if (\function_exists('_PhpScopera143bcca66cb\\mock')) {
    return;
}
function mock() : \_PhpScopera143bcca66cb\Mockery\MockInterface
{
    return new \_PhpScopera143bcca66cb\DummyMock();
}
