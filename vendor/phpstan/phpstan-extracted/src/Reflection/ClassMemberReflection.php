<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

interface ClassMemberReflection
{
    public function getDeclaringClass() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
    public function isStatic() : bool;
    public function isPrivate() : bool;
    public function isPublic() : bool;
    public function getDocComment() : ?string;
}
