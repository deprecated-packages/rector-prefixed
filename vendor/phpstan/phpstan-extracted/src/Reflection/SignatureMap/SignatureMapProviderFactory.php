<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\SignatureMap;

use RectorPrefix20201227\PHPStan\Php\PhpVersion;
class SignatureMapProviderFactory
{
    /** @var PhpVersion */
    private $phpVersion;
    /** @var FunctionSignatureMapProvider */
    private $functionSignatureMapProvider;
    /** @var Php8SignatureMapProvider */
    private $php8SignatureMapProvider;
    public function __construct(\RectorPrefix20201227\PHPStan\Php\PhpVersion $phpVersion, \RectorPrefix20201227\PHPStan\Reflection\SignatureMap\FunctionSignatureMapProvider $functionSignatureMapProvider, \RectorPrefix20201227\PHPStan\Reflection\SignatureMap\Php8SignatureMapProvider $php8SignatureMapProvider)
    {
        $this->phpVersion = $phpVersion;
        $this->functionSignatureMapProvider = $functionSignatureMapProvider;
        $this->php8SignatureMapProvider = $php8SignatureMapProvider;
    }
    public function create() : \RectorPrefix20201227\PHPStan\Reflection\SignatureMap\SignatureMapProvider
    {
        if ($this->phpVersion->getVersionId() < 80000) {
            return $this->functionSignatureMapProvider;
        }
        return $this->php8SignatureMapProvider;
    }
}
