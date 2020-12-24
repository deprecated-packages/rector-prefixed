<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Util;

use _PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion;
final class PhpVersionFactory
{
    public function createIntVersion(string $version) : int
    {
        $explodeDash = \explode('-', $version);
        if (\count($explodeDash) > 1) {
            $version = $explodeDash[0];
        }
        $explodeVersion = \explode('.', $version);
        $countExplodedVersion = \count($explodeVersion);
        if ($countExplodedVersion === 2) {
            return (int) $explodeVersion[0] * 10000 + (int) $explodeVersion[1] * 100;
        }
        if ($countExplodedVersion === 3) {
            return (int) $explodeVersion[0] * 10000 + (int) $explodeVersion[1] * 100 + (int) $explodeVersion[2];
        }
        return (int) $version;
    }
    public function createStringVersion(int $version) : string
    {
        $phpVersion = new \_PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion($version);
        return $phpVersion->getVersionString();
    }
}
