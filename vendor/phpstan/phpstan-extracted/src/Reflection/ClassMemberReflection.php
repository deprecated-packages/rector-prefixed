<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

interface ClassMemberReflection
{
    public function getDeclaringClass() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
    public function isStatic() : bool;
    public function isPrivate() : bool;
    public function isPublic() : bool;
    public function getDocComment() : ?string;
}
