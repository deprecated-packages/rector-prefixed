<?php

namespace _PhpScopera143bcca66cb\ParallelAnalyserIntegrationTest;

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
