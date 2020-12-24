<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\Contract\Mapper;

interface DoctrineEntityAndRepositoryMapperInterface
{
    public function mapRepositoryToEntity(string $name) : ?string;
    public function mapEntityToRepository(string $name) : ?string;
}
