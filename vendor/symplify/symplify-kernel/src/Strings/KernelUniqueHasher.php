<?php

declare (strict_types=1);
namespace Symplify\SymplifyKernel\Strings;

use RectorPrefix2020DecSat\Nette\Utils\Strings;
use Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class KernelUniqueHasher
{
    /**
     * @var StringsConverter
     */
    private $stringsConverter;
    public function __construct()
    {
        $this->stringsConverter = new \Symplify\SymplifyKernel\Strings\StringsConverter();
    }
    public function hashKernelClass(string $kernelClass) : string
    {
        $this->ensureIsNotGenericKernelClass($kernelClass);
        $shortClassName = (string) \RectorPrefix2020DecSat\Nette\Utils\Strings::after($kernelClass, '\\', -1);
        return $this->stringsConverter->camelCaseToGlue($shortClassName, '_');
    }
    private function ensureIsNotGenericKernelClass(string $kernelClass) : void
    {
        if ($kernelClass !== \Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class) {
            return;
        }
        $message = \sprintf('Instead of "%s", provide final Kernel class', \Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class);
        throw new \Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException($message);
    }
}
