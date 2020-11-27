<?php

namespace _PhpScoperbd5d0c5f7638\Bug4017;

/**
 * @template T
 */
interface DoctrineEntityRepository
{
}
interface DoctrineEntityManagerInterface
{
    /**
     * @template T
     * @param class-string<T> $className
     * @return DoctrineEntityRepository<T>
     */
    public function getRepository(string $className) : \_PhpScoperbd5d0c5f7638\Bug4017\DoctrineEntityRepository;
}
/**
 * @phpstan-template TEntityClass
 * @phpstan-extends DoctrineEntityRepository<TEntityClass>
 */
interface MyEntityRepositoryInterface extends \_PhpScoperbd5d0c5f7638\Bug4017\DoctrineEntityRepository
{
}
interface MyEntityManagerInterface extends \_PhpScoperbd5d0c5f7638\Bug4017\DoctrineEntityManagerInterface
{
    /**
     * @template T
     * @param class-string<T> $className
     * @return MyEntityRepositoryInterface<T>
     */
    public function getRepository(string $className) : \_PhpScoperbd5d0c5f7638\Bug4017\MyEntityRepositoryInterface;
}
