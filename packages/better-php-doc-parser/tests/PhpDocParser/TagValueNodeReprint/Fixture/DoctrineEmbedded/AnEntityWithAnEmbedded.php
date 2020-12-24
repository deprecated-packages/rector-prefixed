<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineEmbedded;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping as ORM;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\Embeddable;
final class AnEntityWithAnEmbedded
{
    /**
     * @ORM\Embedded(class="Embeddable")
     */
    private $embedded;
}
