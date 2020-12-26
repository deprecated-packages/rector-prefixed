<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineColumn;

use RectorPrefix2020DecSat\Doctrine\ORM\Mapping as ORM;
final class SomeProperty
{
    /**
     * @ORM\Column
     */
    public $id;
}
