<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap;

use _PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion;
class SignatureMapProviderFactory
{
    /** @var PhpVersion */
    private $phpVersion;
    /** @var FunctionSignatureMapProvider */
    private $functionSignatureMapProvider;
    /** @var Php8SignatureMapProvider */
    private $php8SignatureMapProvider;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion $phpVersion, \_PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap\FunctionSignatureMapProvider $functionSignatureMapProvider, \_PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap\Php8SignatureMapProvider $php8SignatureMapProvider)
    {
        $this->phpVersion = $phpVersion;
        $this->functionSignatureMapProvider = $functionSignatureMapProvider;
        $this->php8SignatureMapProvider = $php8SignatureMapProvider;
    }
    public function create() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap\SignatureMapProvider
    {
        if ($this->phpVersion->getVersionId() < 80000) {
            return $this->functionSignatureMapProvider;
        }
        return $this->php8SignatureMapProvider;
    }
}
