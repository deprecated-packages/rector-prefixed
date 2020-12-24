<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface;
/**
 * @see https://github.com/phpstan/phpstan-src/blob/b1fd47bda2a7a7d25091197b125c0adf82af6757/src/Type/Constant/ConstantStringType.php#L147
 */
final class ConstantStringTypeToCallReflectionResolver implements \_PhpScopere8e811afab72\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface
{
    /**
     * Took from https://github.com/phpstan/phpstan-src/blob/8376548f76e2c845ae047e3010e873015b796818/src/Type/Constant/ConstantStringType.php#L158
     *
     * @see https://regex101.com/r/IE6lcM/4
     *
     * @var string
     */
    private const STATIC_METHOD_REGEX = '#^([a-zA-Z_\\x7f-\\xff\\\\][a-zA-Z0-9_\\x7f-\\xff\\\\]*)::([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)\\z#';
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function supports(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
    }
    /**
     * @param ConstantStringType $type
     * @return FunctionReflection|MethodReflection|null
     */
    public function resolve(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer)
    {
        $value = $type->getValue();
        // 'my_function'
        $name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($value);
        if ($this->reflectionProvider->hasFunction($name, null)) {
            return $this->reflectionProvider->getFunction($name, null);
        }
        // 'MyClass::myStaticFunction'
        $matches = \_PhpScopere8e811afab72\Nette\Utils\Strings::match($value, self::STATIC_METHOD_REGEX);
        if ($matches === null) {
            return null;
        }
        if (!$this->reflectionProvider->hasClass($matches[1])) {
            return null;
        }
        $classReflection = $this->reflectionProvider->getClass($matches[1]);
        if (!$classReflection->hasMethod($matches[2])) {
            return null;
        }
        return $classReflection->getMethod($matches[2], $classMemberAccessAnswerer);
    }
}
