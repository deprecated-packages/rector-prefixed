<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Generic;

use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\CompoundTypeHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
/**
 * Template type strategy suitable for parameter type acceptance contexts
 */
class TemplateTypeParameterStrategy implements \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType $left, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($right instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundTypeHelper::accepts($right, $left, $strictTypes);
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
