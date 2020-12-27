<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

interface ClassMemberReflection
{
    public function getDeclaringClass() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
    public function isStatic() : bool;
    public function isPrivate() : bool;
    public function isPublic() : bool;
    public function getDocComment() : ?string;
}
