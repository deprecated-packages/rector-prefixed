<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineJoinTable;

use _PhpScopere8e811afab72\Doctrine\ORM\Mapping as ORM;
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
