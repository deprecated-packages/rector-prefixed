<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface TypeToCallReflectionResolverInterface
{
    public function supports(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool;
    /**
     * @return FunctionReflection|MethodReflection|null
     */
    public function resolve(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer);
}
