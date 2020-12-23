<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Analyser;

use _PhpScoper0a2ac50786fa\PHPStan\File\FileExcluder;
use _PhpScoper0a2ac50786fa\PHPStan\File\FileHelper;
class IgnoredError
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param mixed[]|string $ignoredError
     * @return string Representation of the ignored error
     */
    public static function stringifyPattern($ignoredError) : string
    {
        if (!\is_array($ignoredError)) {
            return $ignoredError;
        }
        // ignore by path
        if (isset($ignoredError['path'])) {
            return \sprintf('%s in path %s', $ignoredError['message'], $ignoredError['path']);
        } elseif (isset($ignoredError['paths'])) {
            if (\count($ignoredError['paths']) === 1) {
                return \sprintf('%s in path %s', $ignoredError['message'], \implode(', ', $ignoredError['paths']));
            }
            return \sprintf('%s in paths: %s', $ignoredError['message'], \implode(', ', $ignoredError['paths']));
        }
        return $ignoredError['message'];
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param FileHelper $fileHelper
     * @param Error $error
     * @param string $ignoredErrorPattern
     * @param string|null $path
     * @return bool To ignore or not to ignore?
     */
    public static function shouldIgnore(\_PhpScoper0a2ac50786fa\PHPStan\File\FileHelper $fileHelper, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Error $error, string $ignoredErrorPattern, ?string $path) : bool
    {
        // normalize newlines to allow working with ignore-patterns independent of used OS newline-format
        $errorMessage = $error->getMessage();
        $errorMessage = \str_replace(['\\r\\n', '\\r'], '\\n', $errorMessage);
        $ignoredErrorPattern = \str_replace([\preg_quote('_PhpScoper0a2ac50786fa\\r\\n'), \preg_quote('\\r')], \preg_quote('\\n'), $ignoredErrorPattern);
        if ($path !== null) {
            $fileExcluder = new \_PhpScoper0a2ac50786fa\PHPStan\File\FileExcluder($fileHelper, [$path], []);
            if (\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($errorMessage, $ignoredErrorPattern) === null) {
                return \false;
            }
            $isExcluded = $fileExcluder->isExcludedFromAnalysing($error->getFilePath());
            if (!$isExcluded && $error->getTraitFilePath() !== null) {
                return $fileExcluder->isExcludedFromAnalysing($error->getTraitFilePath());
            }
            return $isExcluded;
        }
        return \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($errorMessage, $ignoredErrorPattern) !== null;
    }
}
