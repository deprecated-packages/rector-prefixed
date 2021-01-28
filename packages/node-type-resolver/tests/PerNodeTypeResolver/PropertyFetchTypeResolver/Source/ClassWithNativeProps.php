<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\Source;

class ClassWithNativeProps
{
    public $implicitMixed;
    public string $text;
    public int $number;
    public ?string $textNullable;
    public ?int $numberNullable;
    public \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\Source\Abc $abc;
    public ?\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\Source\Abc $abcNullable;
    public \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\Source\Abc $abcFQ;
    public \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\Source\IDontExist $nonexistent;
    public \RectorPrefix20210128\A\B\C\IDontExist $nonexistentFQ;
    public array $array;
    /** @var array<Abc> */
    public array $arrayOfAbcs;
}
