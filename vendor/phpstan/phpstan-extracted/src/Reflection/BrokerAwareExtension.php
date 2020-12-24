<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
interface BrokerAwareExtension
{
    public function setBroker(\_PhpScopere8e811afab72\PHPStan\Broker\Broker $broker) : void;
}
