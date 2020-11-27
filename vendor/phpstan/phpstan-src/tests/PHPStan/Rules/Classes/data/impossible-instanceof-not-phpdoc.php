<?php

namespace _PhpScoper26e51eeacccf\ImpossibleInstanceofNotPhpDoc;

class Foo
{
    public function doFoo(\stdClass $std)
    {
        if ($std instanceof \stdClass) {
        }
        if ($std instanceof \Exception) {
        }
    }
    /**
     * @param \DateTimeImmutable $date
     */
    public function doBar(\DateTimeInterface $date)
    {
        if ($date instanceof \DateTimeInterface) {
        }
        if ($date instanceof \_PhpScoper26e51eeacccf\ImpossibleInstanceofNotPhpDoc\SomeFinalClass) {
        }
        if ($date instanceof \DateTimeImmutable) {
        }
        if ($date instanceof \DateTime) {
        }
    }
}
final class SomeFinalClass
{
}
