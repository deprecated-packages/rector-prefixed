<?php

namespace RectorPrefix20210504;

class MyOwnClass
{
    public function doFoo() : void
    {
    }
}
\class_alias('RectorPrefix20210504\\MyOwnClass', 'MyOwnClass', \false);
function (\Event $e) : void {
    $e->doFoo();
};
