<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

use RectorPrefix20201227\PHPStan\Broker\Broker;
interface BrokerAwareExtension
{
    public function setBroker(\RectorPrefix20201227\PHPStan\Broker\Broker $broker) : void;
}
