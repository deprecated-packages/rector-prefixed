<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SymplifyKernel\Strings;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class KernelUniqueHasher
{
    /**
     * @var StringsConverter
     */
    private $stringsConverter;
    public function __construct()
    {
        $this->stringsConverter = new \_PhpScopere8e811afab72\Symplify\SymplifyKernel\Strings\StringsConverter();
    }
    public function hashKernelClass(string $kernelClass) : string
    {
        $this->ensureIsNotGenericKernelClass($kernelClass);
        $shortClassName = (string) \_PhpScopere8e811afab72\Nette\Utils\Strings::after($kernelClass, '\\', -1);
        return $this->stringsConverter->camelCaseToGlue($shortClassName, '_');
    }
    private function ensureIsNotGenericKernelClass(string $kernelClass) : void
    {
        if ($kernelClass !== \_PhpScopere8e811afab72\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class) {
            return;
        }
        $message = \sprintf('Instead of "%s", provide final Kernel class', \_PhpScopere8e811afab72\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class);
        throw new \_PhpScopere8e811afab72\Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException($message);
    }
}
