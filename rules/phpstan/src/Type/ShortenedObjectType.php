<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
final class ShortenedObjectType extends \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType
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
