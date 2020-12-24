<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\Contract\Mapper;

interface DoctrineEntityAndRepositoryMapperInterface
{
    public function mapRepositoryToEntity(string $name) : ?string;
    public function mapEntityToRepository(string $name) : ?string;
}
