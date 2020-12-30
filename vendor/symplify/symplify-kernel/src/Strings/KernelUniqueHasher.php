<?php

declare (strict_types=1);
namespace RectorPrefix20201230\Symplify\SymplifyKernel\Strings;

use RectorPrefix20201230\Nette\Utils\Strings;
use RectorPrefix20201230\Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException;
use RectorPrefix20201230\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class KernelUniqueHasher
{
    /**
     * @var StringsConverter
     */
    private $stringsConverter;
    public function __construct()
    {
        $this->stringsConverter = new \RectorPrefix20201230\Symplify\SymplifyKernel\Strings\StringsConverter();
    }
    public function hashKernelClass(string $kernelClass) : string
    {
        $this->ensureIsNotGenericKernelClass($kernelClass);
        $shortClassName = (string) \RectorPrefix20201230\Nette\Utils\Strings::after($kernelClass, '\\', -1);
        return $this->stringsConverter->camelCaseToGlue($shortClassName, '_');
    }
    private function ensureIsNotGenericKernelClass(string $kernelClass) : void
    {
        if ($kernelClass !== \RectorPrefix20201230\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class) {
            return;
        }
        $message = \sprintf('Instead of "%s", provide final Kernel class', \RectorPrefix20201230\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class);
        throw new \RectorPrefix20201230\Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException($message);
    }
}
