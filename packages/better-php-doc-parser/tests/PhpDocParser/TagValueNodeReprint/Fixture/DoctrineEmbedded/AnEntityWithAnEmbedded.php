<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineEmbedded;

use RectorPrefix20210221\Doctrine\ORM\Mapping as ORM;
use Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\Embeddable;
final class AnEntityWithAnEmbedded
{
    /**
     * @ORM\Embedded(class="Embeddable")
     */
    private $embedded;
}
