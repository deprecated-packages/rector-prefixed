<?php

declare (strict_types=1);
namespace Rector\Doctrine\Mapper;

use RectorPrefix20210130\Nette\Utils\Strings;
use Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface;
final class DefaultDoctrineEntityAndRepositoryMapper implements \Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface
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
        $withoutSuffix = \RectorPrefix20210130\Nette\Utils\Strings::substring($repository, 0, -\strlen(self::REPOSITORY));
        // "App\Repository\Some" => "App\Entity\Some"
        return \RectorPrefix20210130\Nette\Utils\Strings::replace($withoutSuffix, self::REPOSITORY_REGEX, 'Entity');
    }
    public function mapEntityToRepository(string $entity) : ?string
    {
        // "Some" => "SomeRepository"
        $withSuffix = $entity . self::REPOSITORY;
        // "App\Entity\SomeRepository" => "App\Repository\SomeRepository"
        return \RectorPrefix20210130\Nette\Utils\Strings::replace($withSuffix, self::ENTITY_REGEX, self::REPOSITORY);
    }
}
