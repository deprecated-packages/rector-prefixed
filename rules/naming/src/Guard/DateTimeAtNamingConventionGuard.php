<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Guard;

use DateTimeInterface;
use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoper0a6b37af0871\Rector\Naming\ValueObject\PropertyRename;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
final class DateTimeAtNamingConventionGuard implements \_PhpScoper0a6b37af0871\Rector\Naming\Contract\Guard\ConflictingGuardInterface
{
    /**
     * @var string
     * @see https://regex101.com/r/1pKLgf/1/
     */
    private const AT_NAMING_REGEX = '#[\\w+]At$#';
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var TypeUnwrapper
     */
    private $typeUnwrapper;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeUnwrapper = $typeUnwrapper;
    }
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return $this->isDateTimeAtNamingConvention($renameValueObject);
    }
    private function isDateTimeAtNamingConvention(\_PhpScoper0a6b37af0871\Rector\Naming\ValueObject\PropertyRename $propertyRename) : bool
    {
        $type = $this->nodeTypeResolver->resolve($propertyRename->getProperty());
        $type = $this->typeUnwrapper->unwrapFirstObjectTypeFromUnionType($type);
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        if (!\is_a($type->getClassName(), \DateTimeInterface::class, \true)) {
            return \false;
        }
        return (bool) \_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($propertyRename->getCurrentName(), self::AT_NAMING_REGEX . '');
    }
}
