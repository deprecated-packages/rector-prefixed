<?php

namespace _PhpScoper26e51eeacccf;

if (\function_exists('_PhpScoper26e51eeacccf\\mock')) {
    return;
}
function mock() : \_PhpScoper26e51eeacccf\Mockery\MockInterface
{
    return new \_PhpScoper26e51eeacccf\DummyMock();
}
