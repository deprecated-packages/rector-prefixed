<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod;

use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\Exception\SignatureCheckFailed;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Util\Autoload\ClassPrinter\PhpParserPrinter;
use _PhpScoperabd03f0baf05\Roave\Signature\CheckerInterface;
use _PhpScoperabd03f0baf05\Roave\Signature\Encoder\Sha1SumEncoder;
use _PhpScoperabd03f0baf05\Roave\Signature\FileContentChecker;
use _PhpScoperabd03f0baf05\Roave\Signature\FileContentSigner;
use _PhpScoperabd03f0baf05\Roave\Signature\SignerInterface;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function sha1;
use function str_replace;
final class FileCacheLoader implements \_PhpScoperabd03f0baf05\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\LoaderMethodInterface
{
    /** @var string */
    private $cacheDirectory;
    /** @var ClassPrinterInterface */
    private $classPrinter;
    /** @var SignerInterface */
    private $signer;
    /** @var CheckerInterface */
    private $checker;
    public function __construct(string $cacheDirectory, \_PhpScoperabd03f0baf05\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface $classPrinter, \_PhpScoperabd03f0baf05\Roave\Signature\SignerInterface $signer, \_PhpScoperabd03f0baf05\Roave\Signature\CheckerInterface $checker)
    {
        $this->cacheDirectory = $cacheDirectory;
        $this->classPrinter = $classPrinter;
        $this->signer = $signer;
        $this->checker = $checker;
    }
    /**
     * {@inheritdoc}
     *
     * @throws SignatureCheckFailed
     */
    public function __invoke(\_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : void
    {
        $filename = $this->cacheDirectory . '/' . \sha1($classInfo->getName());
        if (!\file_exists($filename)) {
            $code = "<?php\n" . $this->classPrinter->__invoke($classInfo);
            \file_put_contents($filename, \str_replace('<?php', "<?php\n// " . $this->signer->sign($code), $code));
        }
        if (!$this->checker->check(\file_get_contents($filename))) {
            throw \_PhpScoperabd03f0baf05\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\Exception\SignatureCheckFailed::fromReflectionClass($classInfo);
        }
        /** @noinspection PhpIncludeInspection */
        require_once $filename;
    }
    public static function defaultFileCacheLoader(string $cacheDirectory) : self
    {
        return new self($cacheDirectory, new \_PhpScoperabd03f0baf05\Roave\BetterReflection\Util\Autoload\ClassPrinter\PhpParserPrinter(), new \_PhpScoperabd03f0baf05\Roave\Signature\FileContentSigner(new \_PhpScoperabd03f0baf05\Roave\Signature\Encoder\Sha1SumEncoder()), new \_PhpScoperabd03f0baf05\Roave\Signature\FileContentChecker(new \_PhpScoperabd03f0baf05\Roave\Signature\Encoder\Sha1SumEncoder()));
    }
}
