<?php

declare (strict_types=1);
namespace PHPStan\Type\Generic;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
/**
 * Template type strategy suitable for return type acceptance contexts
 */
class TemplateTypeArgumentStrategy implements \PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\PHPStan\Type\Generic\TemplateType $left, \PHPStan\Type\Type $right, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($right instanceof \PHPStan\Type\IntersectionType) {
            foreach ($right->getTypes() as $type) {
                if ($this->accepts($left, $type, $strictTypes)->yes()) {
                    return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
                }
            }
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($left->equals($right))->or(\RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($right->equals(new \PHPStan\Type\MixedType())));
    }
    public function isArgument() : bool
    {
        return \true;
    }
    /**
     * @param mixed[] $properties
     */
    public static function __set_state(array $properties) : self
    {
        return new self();
    }
}
