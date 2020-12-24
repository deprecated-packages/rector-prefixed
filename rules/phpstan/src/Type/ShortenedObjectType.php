<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
final class ShortenedObjectType extends \_PhpScopere8e811afab72\PHPStan\Type\ObjectType
{
    /**
     * @var string
     */
    private $fullyQualifiedName;
    public function __construct(string $shortName, string $fullyQualifiedName)
    {
        parent::__construct($shortName);
        $this->fullyQualifiedName = $fullyQualifiedName;
    }
    public function getShortName() : string
    {
        return $this->getClassName();
    }
    public function getFullyQualifiedName() : string
    {
        return $this->fullyQualifiedName;
    }
}
