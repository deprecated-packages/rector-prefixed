<?php

namespace _PhpScoperbd5d0c5f7638\ParallelAnalyserIntegrationTest;

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
