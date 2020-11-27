<?php

namespace _PhpScoperbd5d0c5f7638\AccessPropertiesDateIntervalChild;

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
