<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface PropertyReflection extends \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberReflection
{
    public function getReadableType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function getWritableType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function canChangeTypeAfterAssignment() : bool;
    public function isReadable() : bool;
    public function isWritable() : bool;
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
}
