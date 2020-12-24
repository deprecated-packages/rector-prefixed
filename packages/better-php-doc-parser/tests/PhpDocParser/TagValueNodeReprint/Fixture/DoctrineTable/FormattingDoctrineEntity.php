<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineTable;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(
 *     name="my_entity",
 *     indexes={
 *         @ORM\Index(
 *             name="my_entity_idx", columns={"x", "xx", "xxx", "xxxx"}
 *         ),
 *         @ORM\Index(
 *             name="my_entity_xxx_idx", columns={"xxx"}
 *         )
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\MyEntityRepository")
 */
final class FormattingDoctrineEntity
{
}
