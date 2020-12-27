<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
class StringAlwaysAcceptingObjectWithToStringType extends \PHPStan\Type\StringType
{
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\TypeWithClassName) {
            $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($type->getClassName())) {
                return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
            }
            $typeClass = $broker->getClass($type->getClassName());
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($typeClass->hasNativeMethod('__toString'));
        }
        return parent::accepts($type, $strictTypes);
    }
}
