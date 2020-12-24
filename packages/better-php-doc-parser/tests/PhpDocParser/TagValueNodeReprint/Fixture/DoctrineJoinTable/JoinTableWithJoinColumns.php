<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineJoinTable;

use _PhpScoper2a4e7ab1ecbc\Doctrine\ORM\Mapping as ORM;
final class JoinTableWithJoinColumns
{
    /**
     * @ORM\JoinTable(name="PushCampaignCluster",
     *      joinColumns={
     *          @ORM\JoinColumn(name="pushCampaignId", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="clusterId", referencedColumnName="id")
     *      }
     * )
     */
    public $name;
}
