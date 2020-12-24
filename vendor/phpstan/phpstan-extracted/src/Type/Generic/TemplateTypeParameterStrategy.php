<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Generic;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\CompoundType;
use _PhpScoperb75b35f52b74\PHPStan\Type\CompoundTypeHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
/**
 * Template type strategy suitable for parameter type acceptance contexts
 */
class TemplateTypeParameterStrategy implements \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType $left, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($right instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundTypeHelper::accepts($right, $left, $strictTypes);
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
