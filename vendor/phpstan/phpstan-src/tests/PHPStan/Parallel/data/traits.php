<?php

namespace _PhpScoper88fe6e0ad041\ParallelAnalyserIntegrationTest;

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
