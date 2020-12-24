<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source;

class ParentObject
{
    private function toBePublicMethod()
    {
    }
    static function toBePublicStaticMethod()
    {
    }
    protected function toBeProtectedMethod()
    {
    }
    private function toBePrivateMethod()
    {
    }
}
