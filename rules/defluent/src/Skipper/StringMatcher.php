<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Skipper;

final class StringMatcher
{
    /**
     * @param string[] $allowedTypes
     */
    public function isAllowedType(string $currentType, array $allowedTypes) : bool
    {
        foreach ($allowedTypes as $allowedType) {
            if (\is_a($currentType, $allowedType, \true)) {
                return \true;
            }
            if (\fnmatch($allowedType, $currentType, \FNM_NOESCAPE)) {
                return \true;
            }
        }
        return \false;
    }
}
