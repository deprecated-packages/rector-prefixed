<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Strings;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class KernelUniqueHasher
{
    /**
     * @var StringsConverter
     */
    private $stringsConverter;
    public function __construct()
    {
        $this->stringsConverter = new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Strings\StringsConverter();
    }
    public function hashKernelClass(string $kernelClass) : string
    {
        $this->ensureIsNotGenericKernelClass($kernelClass);
        $shortClassName = (string) \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::after($kernelClass, '\\', -1);
        return $this->stringsConverter->camelCaseToGlue($shortClassName, '_');
    }
    private function ensureIsNotGenericKernelClass(string $kernelClass) : void
    {
        if ($kernelClass !== \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class) {
            return;
        }
        $message = \sprintf('Instead of "%s", provide final Kernel class', \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class);
        throw new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException($message);
    }
}
