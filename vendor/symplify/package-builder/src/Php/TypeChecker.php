<?php

declare (strict_types=1);
namespace RectorPrefix20210117\Symplify\PackageBuilder\Php;

final class TypeChecker
{
    /**
     * @param string[] $types
     */
    public function isInstanceOf($object, array $types) : bool
    {
        foreach ($types as $type) {
            if (\is_a($object, $type, \true)) {
                return \true;
            }
        }
        return \false;
    }
}
