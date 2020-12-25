<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source;

use _PhpScoper8b9c402c5f32\Doctrine\ORM\Mapping as ORM;
use _PhpScoper8b9c402c5f32\JMS\Serializer\Annotation as Serializer;
use _PhpScoper8b9c402c5f32\Symfony\Component\Validator\Constraints as Assert;
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
