<?php

// lint >= 7.4
namespace _PhpScoper88fe6e0ad041\CoalesceAssign;

class Foo
{
    public function doFoo(string $string, ?string $nullableString)
    {
        $emptyArray = [];
        $arrayWithFoo = ['foo' => 'foo'];
        $arrayWithMaybeFoo = [];
        if (\rand(0, 1)) {
            $arrayWithMaybeFoo['foo'] = 'foo';
        }
        $arrayAfterAssignment = [];
        $arrayAfterAssignment['foo'] ??= 'foo';
        $arrayWithFooAfterAssignment = ['foo' => 'foo'];
        $arrayWithFooAfterAssignment['foo'] ??= 'bar';
        $nonexistentVariableAfterAssignment ??= 'foo';
        if (\rand(0, 1)) {
            $maybeNonexistentVariableAfterAssignment = 'foo';
        }
        $maybeNonexistentVariableAfterAssignment ??= 'bar';
        die;
    }
}
