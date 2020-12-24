<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
class StringAlwaysAcceptingObjectWithToStringType extends \_PhpScopere8e811afab72\PHPStan\Type\StringType
{
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            $broker = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($type->getClassName())) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
            }
            $typeClass = $broker->getClass($type->getClassName());
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($typeClass->hasNativeMethod('__toString'));
        }
        return parent::accepts($type, $strictTypes);
    }
}
