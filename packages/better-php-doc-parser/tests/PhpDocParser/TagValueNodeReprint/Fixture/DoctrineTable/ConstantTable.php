<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineTable;

use _PhpScoper267b3276efc2\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(name=ConstantTable::TABLE_NAME)
 */
class ConstantTable
{
    const TABLE_NAME = 'some_table_name';
}
