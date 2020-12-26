<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineJoinTable;

use RectorPrefix2020DecSat\Doctrine\ORM\Mapping as ORM;
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
