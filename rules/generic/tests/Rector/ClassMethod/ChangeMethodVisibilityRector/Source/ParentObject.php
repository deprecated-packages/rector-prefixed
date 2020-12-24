<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source;

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
