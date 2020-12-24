<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DeadCode\Tests\Rector\MethodCall\RemoveEmptyMethodCallRector\Source;

use DateTime;
class NonEmptyMethod
{
    private $d;
    public function __construct(\DateTime $d)
    {
        $this->d = $d;
    }
    public function run()
    {
        return $this->d->format('Y-m-d H:i:s');
    }
}
