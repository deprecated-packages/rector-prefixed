<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source;

use RectorPrefix2020DecSat\Doctrine\ORM\Mapping as ORM;
use RectorPrefix2020DecSat\JMS\Serializer\Annotation as Serializer;
use RectorPrefix2020DecSat\Symfony\Component\Validator\Constraints as Assert;
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
