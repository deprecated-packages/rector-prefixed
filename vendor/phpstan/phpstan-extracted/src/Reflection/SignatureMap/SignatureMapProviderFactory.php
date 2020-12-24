<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\SignatureMap;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Php\PhpVersion;
class SignatureMapProviderFactory
{
    /** @var PhpVersion */
    private $phpVersion;
    /** @var FunctionSignatureMapProvider */
    private $functionSignatureMapProvider;
    /** @var Php8SignatureMapProvider */
    private $php8SignatureMapProvider;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Php\PhpVersion $phpVersion, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\SignatureMap\FunctionSignatureMapProvider $functionSignatureMapProvider, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\SignatureMap\Php8SignatureMapProvider $php8SignatureMapProvider)
    {
        $this->phpVersion = $phpVersion;
        $this->functionSignatureMapProvider = $functionSignatureMapProvider;
        $this->php8SignatureMapProvider = $php8SignatureMapProvider;
    }
    public function create() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\SignatureMap\SignatureMapProvider
    {
        if ($this->phpVersion->getVersionId() < 80000) {
            return $this->functionSignatureMapProvider;
        }
        return $this->php8SignatureMapProvider;
    }
}
