<?php

namespace _PhpScoper006a73f0e455\ParallelAnalyserIntegrationTest;

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
