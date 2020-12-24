<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Guard;

use DateTimeInterface;
use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\Guard\ConflictingGuardInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObject\PropertyRename;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
final class DateTimeAtNamingConventionGuard implements \_PhpScoperb75b35f52b74\Rector\Naming\Contract\Guard\ConflictingGuardInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeUnwrapper = $typeUnwrapper;
    }
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return $this->isDateTimeAtNamingConvention($renameValueObject);
    }
    private function isDateTimeAtNamingConvention(\_PhpScoperb75b35f52b74\Rector\Naming\ValueObject\PropertyRename $propertyRename) : bool
    {
        $type = $this->nodeTypeResolver->resolve($propertyRename->getProperty());
        $type = $this->typeUnwrapper->unwrapFirstObjectTypeFromUnionType($type);
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        if (!\is_a($type->getClassName(), \DateTimeInterface::class, \true)) {
            return \false;
        }
        return (bool) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($propertyRename->getCurrentName(), self::AT_NAMING_REGEX . '');
    }
}
