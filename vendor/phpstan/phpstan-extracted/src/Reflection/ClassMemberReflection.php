<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

interface ClassMemberReflection
{
    public function getDeclaringClass() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
    public function isStatic() : bool;
    public function isPrivate() : bool;
    public function isPublic() : bool;
    public function getDocComment() : ?string;
}
