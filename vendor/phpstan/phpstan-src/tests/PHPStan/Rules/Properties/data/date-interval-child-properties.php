<?php

namespace _PhpScoper88fe6e0ad041\AccessPropertiesDateIntervalChild;

class DateIntervalChild extends \DateInterval
{
    public function doFoo()
    {
        echo $this->invert;
        echo $this->d;
        echo $this->m;
        echo $this->y;
        echo $this->nonexistent;
    }
}
