<?php

namespace _PhpScoper26e51eeacccf\ParallelAnalyserIntegrationTest;

class Foo
{
    use FooTrait;
}
class Bar
{
    use FooTrait;
    /** @var int */
    private $test;
}
