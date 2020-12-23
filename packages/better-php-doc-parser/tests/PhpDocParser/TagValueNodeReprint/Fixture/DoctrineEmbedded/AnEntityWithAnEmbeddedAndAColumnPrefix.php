<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineEmbedded;

use _PhpScoper0a2ac50786fa\Doctrine\ORM\Mapping as ORM;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\Embeddable;
final class AnEntityWithAnEmbeddedAndAColumnPrefix
{
    /**
     * @ORM\Embedded(class="Embeddable", columnPrefix="prefix_")
     */
    private $embedded;
}
