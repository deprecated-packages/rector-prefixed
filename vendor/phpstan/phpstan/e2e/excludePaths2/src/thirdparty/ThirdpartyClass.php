<?php

namespace RectorPrefix20210504;

class ThirdpartyClass
{
    public function test()
    {
        $this->undefinedVariable = 123;
    }
}
\class_alias('RectorPrefix20210504\\ThirdpartyClass', 'ThirdpartyClass', \false);
