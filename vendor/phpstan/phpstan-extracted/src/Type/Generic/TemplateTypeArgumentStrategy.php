<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Generic;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
/**
 * Template type strategy suitable for return type acceptance contexts
 */
class TemplateTypeArgumentStrategy implements \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType $left, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($right instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            foreach ($right->getTypes() as $type) {
                if ($this->accepts($left, $type, $strictTypes)->yes()) {
                    return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
                }
            }
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean($left->equals($right))->or(\_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean($right->equals(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType())));
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
