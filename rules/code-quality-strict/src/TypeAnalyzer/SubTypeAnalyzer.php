<?php

declare (strict_types=1);
namespace Rector\CodeQualityStrict\TypeAnalyzer;

use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
final class SubTypeAnalyzer
{
    public function isObjectSubType(\PHPStan\Type\Type $checkedType, \PHPStan\Type\Type $mainType) : bool
    {
        if (!$checkedType instanceof \PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        if (!$mainType instanceof \PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        $checkedClassName = $checkedType instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType ? $checkedType->getFullyQualifiedName() : $checkedType->getClassName();
        $mainClassName = $mainType instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType ? $mainType->getFullyQualifiedName() : $mainType->getClassName();
        if (\is_a($checkedClassName, $mainClassName, \true)) {
            return \true;
        }
        // child of every object
        return $mainClassName === 'stdClass';
    }
}
