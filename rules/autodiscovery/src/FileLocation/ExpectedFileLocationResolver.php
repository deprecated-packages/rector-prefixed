<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Autodiscovery\FileLocation;

final class ExpectedFileLocationResolver
{
    /**
     * Resolves if is suffix in the same category, e.g. "Exception/SomeException.php"
     */
    public function resolve(string $escapedGroupName, string $suffixPattern) : string
    {
        $escapedGroupName = \preg_quote($escapedGroupName, '#');
        $escapedSuffixPattern = \preg_quote($suffixPattern, '#');
        return \sprintf('#\\/%s\\/.+%s#', $escapedGroupName, $escapedSuffixPattern);
    }
}
