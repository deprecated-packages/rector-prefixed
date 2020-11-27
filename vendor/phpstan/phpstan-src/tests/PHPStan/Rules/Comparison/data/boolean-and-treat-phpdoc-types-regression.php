<?php

namespace _PhpScoper006a73f0e455\BooleanAndTreatPhpDocTypesAsCertainRegression;

class Foo
{
    public function isDebugMode() : bool
    {
        return \true;
    }
    public function something() : void
    {
    }
    public function doFoo() : void
    {
        $isDev = $this->isDebugMode();
        $used = \false;
        while (\true) {
            if ($isDev && $used) {
                return;
            }
            $used = \true;
            $this->something();
        }
    }
}
