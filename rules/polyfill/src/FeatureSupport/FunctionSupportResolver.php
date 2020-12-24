<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Polyfill\FeatureSupport;

use _PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersion;
final class FunctionSupportResolver
{
    /**
     * @var array<int, string[]>
     */
    private const FUNCTIONS_BY_VERSION = [\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersion::PHP_56 => ['session_abort', 'hash_equals', 'ldap_escape'], \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersion::PHP_70 => ['random_int', 'random_bytes', 'intdiv', 'preg_replace_callback_array', 'error_clear_last'], \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersion::PHP_71 => ['is_iterable'], \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersion::PHP_72 => ['spl_object_id', 'stream_isatty'], \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersion::PHP_73 => ['array_key_first', 'array_key_last', 'hrtime', 'is_countable'], \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersion::PHP_74 => ['get_mangled_object_vars', 'mb_str_split', 'password_algos']];
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    public function isFunctionSupported(string $desiredFunction) : bool
    {
        foreach (self::FUNCTIONS_BY_VERSION as $version => $functions) {
            if (!\in_array($desiredFunction, $functions, \true)) {
                continue;
            }
            if (!$this->phpVersionProvider->isAtLeastPhpVersion($version)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
}
