<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
interface BrokerAwareExtension
{
    public function setBroker(\_PhpScoperb75b35f52b74\PHPStan\Broker\Broker $broker) : void;
}
