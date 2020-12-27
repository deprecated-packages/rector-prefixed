<?php

declare (strict_types=1);
namespace PHPStan\Type\Generic;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\CompoundType;
use PHPStan\Type\CompoundTypeHelper;
use PHPStan\Type\Type;
/**
 * Template type strategy suitable for parameter type acceptance contexts
 */
class TemplateTypeParameterStrategy implements \PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\PHPStan\Type\Generic\TemplateType $left, \PHPStan\Type\Type $right, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($right instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($right, $left, $strictTypes);
        }
        return $left->getBound()->accepts($right, $strictTypes);
    }
    public function isArgument() : bool
    {
        return \false;
    }
    /**
     * @param mixed[] $properties
     */
    public static function __set_state(array $properties) : self
    {
        return new self();
    }
}
