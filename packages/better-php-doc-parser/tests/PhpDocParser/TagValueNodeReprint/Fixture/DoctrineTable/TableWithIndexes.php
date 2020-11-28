<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineTable;

use _PhpScoperabd03f0baf05\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(name="amenity_building", uniqueConstraints={@ORM\UniqueConstraint(name="building_id_amenity_id",
 *      columns={"building_id", "amenity_id"})}
 * )
 */
final class TableWithIndexes
{
}
