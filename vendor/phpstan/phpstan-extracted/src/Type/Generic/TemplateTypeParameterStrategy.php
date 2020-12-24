<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic;

use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundTypeHelper;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
/**
 * Template type strategy suitable for parameter type acceptance contexts
 */
class TemplateTypeParameterStrategy implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType $left, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($right instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundTypeHelper::accepts($right, $left, $strictTypes);
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
