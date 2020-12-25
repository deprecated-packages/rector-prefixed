<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineCustomIdGenerator;

use _PhpScoperbf340cb0be9d\Doctrine\ORM\Mapping as ORM;
class CustomIdGenerator
{
    /**
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;
}
