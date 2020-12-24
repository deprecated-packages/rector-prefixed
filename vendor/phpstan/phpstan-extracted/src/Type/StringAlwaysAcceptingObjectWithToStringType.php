<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\Broker\Broker;
use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
class StringAlwaysAcceptingObjectWithToStringType extends \_PhpScoper0a6b37af0871\PHPStan\Type\StringType
{
    public function accepts(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
            $broker = \_PhpScoper0a6b37af0871\PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($type->getClassName())) {
                return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
            }
            $typeClass = $broker->getClass($type->getClassName());
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean($typeClass->hasNativeMethod('__toString'));
        }
        return parent::accepts($type, $strictTypes);
    }
}
