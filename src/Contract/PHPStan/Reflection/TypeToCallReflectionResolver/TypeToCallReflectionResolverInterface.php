<?php

declare (strict_types=1);
namespace Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Type;
interface TypeToCallReflectionResolverInterface
{
    public function supports(\PHPStan\Type\Type $type) : bool;
    /**
     * @return FunctionReflection|MethodReflection|null
     */
    public function resolve(\PHPStan\Type\Type $type, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer);
}
