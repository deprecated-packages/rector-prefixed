<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineJoinTable;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping as ORM;
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
