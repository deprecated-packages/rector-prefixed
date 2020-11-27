<?php

namespace _PhpScoper26e51eeacccf\ClosureWithInferredTypehint;

class Foo
{
    public function doFoo()
    {
        $this->doBar(function ($foo, $bar) {
            die;
        });
        $this->doBaz(function ($foo, $bar) {
            die;
        });
    }
    /**
     * @param \Closure(\DateTime|\stdClass): void $closure
     */
    private function doBar(\Closure $closure)
    {
    }
    /**
     * @param callable(\DateTime|\stdClass): void $closure
     */
    private function doBaz(callable $closure)
    {
    }
}
