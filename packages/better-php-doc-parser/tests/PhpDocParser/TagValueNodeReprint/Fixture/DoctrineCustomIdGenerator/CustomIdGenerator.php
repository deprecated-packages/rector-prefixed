<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineCustomIdGenerator;

use _PhpScoper567b66d83109\Doctrine\ORM\Mapping as ORM;
class CustomIdGenerator
{
    /**
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;
}
