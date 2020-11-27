<?php

declare (strict_types=1);
namespace Rector\Naming\Guard;

use DateTimeInterface;
use _PhpScoperbd5d0c5f7638\Nette\Utils\Strings;
use PHPStan\Type\TypeWithClassName;
use Rector\Naming\Contract\Guard\GuardInterface;
use Rector\Naming\Contract\RenameValueObjectInterface;
use Rector\Naming\ValueObject\PropertyRename;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
final class DateTimeAtNamingConventionGuard implements \Rector\Naming\Contract\Guard\GuardInterface
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
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeUnwrapper = $typeUnwrapper;
    }
    /**
     * @param PropertyRename $renameValueObject
     */
    public function check(\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        return $this->isDateTimeAtNamingConvention($renameValueObject);
    }
    /**
     * @param PropertyRename $renameValueObject
     */
    private function isDateTimeAtNamingConvention(\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : bool
    {
        $type = $this->nodeTypeResolver->resolve($renameValueObject->getProperty());
        $type = $this->typeUnwrapper->unwrapFirstObjectTypeFromUnionType($type);
        if (!$type instanceof \PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        if (!\is_a($type->getClassName(), \DateTimeInterface::class, \true)) {
            return \false;
        }
        return (bool) \_PhpScoperbd5d0c5f7638\Nette\Utils\Strings::match($renameValueObject->getCurrentName(), self::AT_NAMING_REGEX . '');
    }
}
