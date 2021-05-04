<?php

namespace RectorPrefix20210504;

use RectorPrefix20210504\Tester\Assert;
class TautologyTest extends \RectorPrefix20210504\Tester\TestCase
{
    public function testOne() : void
    {
        \RectorPrefix20210504\Tester\Assert::true(\true);
        exit(255);
    }
}
\class_alias('RectorPrefix20210504\\TautologyTest', 'TautologyTest', \false);
(new \RectorPrefix20210504\TautologyTest())->run();
