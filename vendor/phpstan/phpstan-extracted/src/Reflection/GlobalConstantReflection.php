<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface GlobalConstantReflection
{
    public function getName() : string;
    public function getValueType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function getFileName() : ?string;
}
