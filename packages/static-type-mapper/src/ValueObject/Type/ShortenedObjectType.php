<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
final class ShortenedObjectType extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType
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
