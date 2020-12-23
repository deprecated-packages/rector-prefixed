<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\SignatureMap;

use _PhpScoper0a2ac50786fa\PHPStan\Php\PhpVersion;
class SignatureMapProviderFactory
{
    /** @var PhpVersion */
    private $phpVersion;
    /** @var FunctionSignatureMapProvider */
    private $functionSignatureMapProvider;
    /** @var Php8SignatureMapProvider */
    private $php8SignatureMapProvider;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Php\PhpVersion $phpVersion, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\SignatureMap\FunctionSignatureMapProvider $functionSignatureMapProvider, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\SignatureMap\Php8SignatureMapProvider $php8SignatureMapProvider)
    {
        $this->phpVersion = $phpVersion;
        $this->functionSignatureMapProvider = $functionSignatureMapProvider;
        $this->php8SignatureMapProvider = $php8SignatureMapProvider;
    }
    public function create() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\SignatureMap\SignatureMapProvider
    {
        if ($this->phpVersion->getVersionId() < 80000) {
            return $this->functionSignatureMapProvider;
        }
        return $this->php8SignatureMapProvider;
    }
}
