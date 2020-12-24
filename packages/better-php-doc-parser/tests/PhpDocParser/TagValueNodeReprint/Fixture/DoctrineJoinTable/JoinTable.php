<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineJoinTable;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping as ORM;
final class JoinTable
{
    /**
     * @ORM\JoinTable(name="page_template_area",
     *      joinColumns={@ORM\JoinColumn(name="template_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="area_id", referencedColumnName="id")}
     * )
     */
    public $name;
}
class Area
{
}
