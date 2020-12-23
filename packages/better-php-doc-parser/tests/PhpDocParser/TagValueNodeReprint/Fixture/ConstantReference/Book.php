<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\ConstantReference;

use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\ApiFilter;
use _PhpScoper0a2ac50786fa\Doctrine\ORM\Mapping as ORM;
final class Book
{
    /**
     * @ApiFilter(Book::class)
     * @ORM\Column()
     */
    public $filterable;
}
