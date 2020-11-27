<?php

namespace _PhpScoper88fe6e0ad041\Bug3866;

use DateTimeImmutable;
use Ds\Set;
use Iterator;
use function PHPStan\Analyser\assertType;
abstract class PHPStanBug
{
    public function test() : void
    {
        /** @var Set<class-string> $set */
        $set = new \Ds\Set();
        foreach ($this->a() as $item) {
            $set->add(\get_class($item));
        }
        foreach ($this->b() as $item) {
            $set->add(\get_class($item));
        }
        foreach ($this->c() as $item) {
            $set->add($item);
        }
        \PHPStan\Analyser\assertType('Ds\\Set<class-string>', $set);
        $set->sort();
    }
    /**
     * @return Iterator<object>
     */
    public abstract function a() : \Iterator;
    /**
     * @return Iterator<object>
     */
    private function b() : \Iterator
    {
        (yield new \DateTimeImmutable());
    }
    /**
     * @return Iterator<class-string<object>>
     */
    private function c() : \Iterator
    {
        (yield \DateTimeImmutable::class);
    }
}
