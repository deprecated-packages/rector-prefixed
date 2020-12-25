<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source;

use _PhpScoperbf340cb0be9d\Doctrine\ORM\Mapping as ORM;
use _PhpScoperbf340cb0be9d\JMS\Serializer\Annotation as Serializer;
use _PhpScoperbf340cb0be9d\Symfony\Component\Validator\Constraints as Assert;
final class ManyToPropertyClass
{
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Spaceflow\Api\Reservation\Entity\Reservation", mappedBy="amenity", cascade={"persist", "merge"})
     * @Serializer\Type("int")
     * @Assert\Range(
     *     min = 0,
     *     max = 2629744
     * )
     * @Assert\Url(
     *     protocols = {"https"}
     * )
     */
    private $manyTo;
}
