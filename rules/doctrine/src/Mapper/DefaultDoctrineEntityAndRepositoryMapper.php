<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Doctrine\Mapper;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface;
final class DefaultDoctrineEntityAndRepositoryMapper implements \_PhpScoper0a6b37af0871\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface
{
    /**
     * @var string
     */
    private const REPOSITORY = 'Repository';
    /**
     * @var string
     * @see https://regex101.com/r/WrYZ0d/1
     */
    private const REPOSITORY_REGEX = '#Repository#';
    /**
     * @var string
     * @see https://regex101.com/r/2a2CY6/1
     */
    private const ENTITY_REGEX = '#Entity#';
    public function mapRepositoryToEntity(string $repository) : ?string
    {
        // "SomeRepository" => "Some"
        $withoutSuffix = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::substring($repository, 0, -\strlen(self::REPOSITORY));
        // "App\Repository\Some" => "App\Entity\Some"
        return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($withoutSuffix, self::REPOSITORY_REGEX, 'Entity');
    }
    public function mapEntityToRepository(string $entity) : ?string
    {
        // "Some" => "SomeRepository"
        $withSuffix = $entity . self::REPOSITORY;
        // "App\Entity\SomeRepository" => "App\Repository\SomeRepository"
        return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::replace($withSuffix, self::ENTITY_REGEX, self::REPOSITORY);
    }
}
