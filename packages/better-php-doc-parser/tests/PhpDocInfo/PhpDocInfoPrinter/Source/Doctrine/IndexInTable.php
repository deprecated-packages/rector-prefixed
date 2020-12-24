<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Doctrine;

use _PhpScopere8e811afab72\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(
 *     name="building",
 *     indexes={
 *          @ORM\Index(name="isDemoBuilding", columns={"is_demo_building"})
 *     }
 * )
 */
final class IndexInTable
{
}
