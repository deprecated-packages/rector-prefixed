<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Generic;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface TemplateTypeStrategy
{
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType $left, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function isArgument() : bool;
}
