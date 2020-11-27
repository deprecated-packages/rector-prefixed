<?php

namespace _PhpScoper006a73f0e455\MultipleClasses;

class Foo
{
    /**
     * @param self $self
     */
    public function doFoo($self)
    {
        'Foo';
    }
    /**
     * @return self
     */
    public function returnSelf()
    {
    }
}
class Bar
{
    /**
     * @param self $self
     */
    public function doFoo($self)
    {
        'Bar';
    }
    /**
     * @return self
     */
    public function returnSelf()
    {
    }
}
