<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Doctrine\Contract\Mapper;

interface DoctrineEntityAndRepositoryMapperInterface
{
    public function mapRepositoryToEntity(string $name) : ?string;
    public function mapEntityToRepository(string $name) : ?string;
}
