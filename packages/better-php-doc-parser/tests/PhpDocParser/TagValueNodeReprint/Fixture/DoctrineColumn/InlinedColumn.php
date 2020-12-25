<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineColumn;

use _PhpScoper50d83356d739\Doctrine\ORM\Mapping as ORM;
final class InlinedColumn
{
    /** @ORM\Column(name="url", type="string") */
    private $loginCount;
}
