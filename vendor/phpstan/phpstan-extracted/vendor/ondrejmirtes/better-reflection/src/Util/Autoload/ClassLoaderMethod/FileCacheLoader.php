<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\Exception\SignatureCheckFailed;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter\PhpParserPrinter;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\Signature\CheckerInterface;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\Signature\Encoder\Sha1SumEncoder;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\Signature\FileContentChecker;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\Signature\FileContentSigner;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\Signature\SignerInterface;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function sha1;
use function str_replace;
final class FileCacheLoader implements \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\LoaderMethodInterface
{
    /** @var string */
    private $cacheDirectory;
    /** @var ClassPrinterInterface */
    private $classPrinter;
    /** @var SignerInterface */
    private $signer;
    /** @var CheckerInterface */
    private $checker;
    public function __construct(string $cacheDirectory, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter\ClassPrinterInterface $classPrinter, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\Signature\SignerInterface $signer, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\Signature\CheckerInterface $checker)
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
    public function __invoke(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : void
    {
        $filename = $this->cacheDirectory . '/' . \sha1($classInfo->getName());
        if (!\file_exists($filename)) {
            $code = "<?php\n" . $this->classPrinter->__invoke($classInfo);
            \file_put_contents($filename, \str_replace('<?php', "<?php\n// " . $this->signer->sign($code), $code));
        }
        if (!$this->checker->check(\file_get_contents($filename))) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod\Exception\SignatureCheckFailed::fromReflectionClass($classInfo);
        }
        /** @noinspection PhpIncludeInspection */
        require_once $filename;
    }
    public static function defaultFileCacheLoader(string $cacheDirectory) : self
    {
        return new self($cacheDirectory, new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassPrinter\PhpParserPrinter(), new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\Signature\FileContentSigner(new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\Signature\Encoder\Sha1SumEncoder()), new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\Signature\FileContentChecker(new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\Signature\Encoder\Sha1SumEncoder()));
    }
}
