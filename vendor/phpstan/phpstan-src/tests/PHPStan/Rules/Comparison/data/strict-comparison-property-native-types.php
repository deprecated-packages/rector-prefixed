<?php

// lint >= 7.4
namespace _PhpScoper006a73f0e455\StrictComparisonPropertyNativeTypes;

class Foo
{
    private string $string;
    private ?string $nullableString;
    public function doFoo() : void
    {
        if ($this->string === null) {
        }
        if ($this->nullableString === null) {
        }
    }
    public function doBar() : void
    {
        if ($this->string !== null) {
        }
        if ($this->nullableString !== null) {
        }
    }
    public function doBaz() : void
    {
        if (null === $this->string) {
        }
        if (null === $this->nullableString) {
        }
    }
    public function doLorem() : void
    {
        if (null !== $this->string) {
        }
        if (null !== $this->nullableString) {
        }
    }
}
