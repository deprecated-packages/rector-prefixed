<?php

declare(strict_types=1);

namespace Symplify\Skipper\FileSystem;

use Nette\Utils\Strings;

/**
 * @see \Symplify\Skipper\Tests\FileSystem\PathNormalizerTest
 */
final class PathNormalizer
{
    /**
     * @var string
     * @see https://regex101.com/r/ZB2dFV/2
     */
    private const ONLY_ENDS_WITH_ASTERISK_REGEX = '#^[^*](.*?)\*$#';

    /**
     * @var string
     * @see https://regex101.com/r/aVUDjM/2
     */
    private const ONLY_STARTS_WITH_ASTERISK_REGEX = '#^\*(.*?)[^*]$#';

    public function normalizeForFnmatch(string $path): string
    {
        // ends with *
        if (Strings::match($path, self::ONLY_ENDS_WITH_ASTERISK_REGEX)) {
            return '*' . $path;
        }

        // starts with *
        if (Strings::match($path, self::ONLY_STARTS_WITH_ASTERISK_REGEX)) {
            return $path . '*';
        }

        if (Strings::contains($path, '..')) {
            $path = realpath($path);
            if ($path === false) {
                return '';
            }
        }

        return $path;
    }
}
