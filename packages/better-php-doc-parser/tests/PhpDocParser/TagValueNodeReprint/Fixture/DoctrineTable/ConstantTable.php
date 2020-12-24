<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineTable;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(name=ConstantTable::TABLE_NAME)
 */
class ConstantTable
{
    const TABLE_NAME = 'some_table_name';
}
