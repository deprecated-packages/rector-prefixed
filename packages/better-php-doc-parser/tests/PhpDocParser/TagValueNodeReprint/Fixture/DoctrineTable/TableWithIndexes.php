<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineTable;

use _PhpScoper2a4e7ab1ecbc\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(name="amenity_building", uniqueConstraints={@ORM\UniqueConstraint(name="building_id_amenity_id",
 *      columns={"building_id", "amenity_id"})}
 * )
 */
final class TableWithIndexes
{
}
