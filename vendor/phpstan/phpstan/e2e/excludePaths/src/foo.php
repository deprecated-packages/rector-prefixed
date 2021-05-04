<?php

namespace RectorPrefix20210504\App;

class Foo extends \RectorPrefix20210504\ThirdParty\Bar
{
    public function doFoo() : void
    {
        $this->doBar();
    }
}
