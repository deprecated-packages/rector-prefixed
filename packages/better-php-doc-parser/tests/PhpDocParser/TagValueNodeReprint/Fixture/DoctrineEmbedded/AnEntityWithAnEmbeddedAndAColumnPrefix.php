<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineEmbedded;

use _PhpScoperf18a0c41e2d2\Doctrine\ORM\Mapping as ORM;
use Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\Embeddable;
final class AnEntityWithAnEmbeddedAndAColumnPrefix
{
    /**
     * @ORM\Embedded(class="Embeddable", columnPrefix="prefix_")
     */
    private $embedded;
}
