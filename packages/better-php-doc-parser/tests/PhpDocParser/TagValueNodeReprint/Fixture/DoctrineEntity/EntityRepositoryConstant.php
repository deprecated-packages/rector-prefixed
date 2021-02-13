<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineEntity;

use RectorPrefix20210213\Doctrine\ORM\Mapping as ORM;
use Rector\BetterPhpDocParser\Tests\PhpDocParser\DoctrineOrmTagParser\Source\ExistingRepositoryClass;
/**
 * @ORM\Entity(repositoryClass=ExistingRepositoryClass::class)
 */
final class EntityRepositoryConstant
{
}
