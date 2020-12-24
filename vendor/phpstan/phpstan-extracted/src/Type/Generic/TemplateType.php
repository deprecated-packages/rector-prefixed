<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Generic;

use _PhpScoperb75b35f52b74\PHPStan\Type\CompoundType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface TemplateType extends \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType
{
    public function getName() : string;
    public function getScope() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeScope;
    public function getBound() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function toArgument() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType;
    public function isArgument() : bool;
    public function isValidVariance(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $a, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $b) : bool;
    public function getVariance() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance;
}
