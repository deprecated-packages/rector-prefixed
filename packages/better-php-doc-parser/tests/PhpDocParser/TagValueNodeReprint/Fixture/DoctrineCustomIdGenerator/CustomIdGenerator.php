<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineCustomIdGenerator;

use _PhpScoperbd5d0c5f7638\Doctrine\ORM\Mapping as ORM;
class CustomIdGenerator
{
    /**
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;
}
