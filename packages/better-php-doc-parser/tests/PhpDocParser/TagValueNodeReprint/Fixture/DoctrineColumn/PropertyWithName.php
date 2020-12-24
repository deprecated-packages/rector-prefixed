<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineColumn;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping as ORM;
final class PropertyWithName
{
    /**
     * @ORM\Column(type="string", name="hey")
     * @ORM\Column(name="hey", type="string")
     */
    public $name;
}
