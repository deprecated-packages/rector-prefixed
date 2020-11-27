<?php

namespace _PhpScoper26e51eeacccf\TraitsCachingIssue;

class TestClassUsingTrait
{
    use TraitOne;
    /**
     * @return \stdClass
     */
    public function doBar()
    {
        return $this->doFoo();
    }
    public function doBaz() : void
    {
        $class = new class
        {
            use TraitTwo;
            /**
             * @return \stdClass
             */
            public function doBar()
            {
                return $this->doFoo();
            }
        };
    }
}
