<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source;

use _PhpScoper0a6b37af0871\Doctrine\ORM\Mapping as ORM;
final class DoctrinePropertyClass
{
    /**
     * @ORM\JoinTable(name="fos_user_user_group",
     *     joinColumns={@ORM\JoinColumn(referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(referencedColumnName="id")}
     * )
     */
    public $someProperty;
}
