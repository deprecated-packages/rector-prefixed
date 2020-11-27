<?php

namespace _PhpScoper006a73f0e455;

$stringFalse = 'Foo';
$stringFalse[\false] = 'A';
$stringObject = 'Foo';
$stringObject[new \stdClass()] = 'B';
$stringFloat = 'Foo';
$stringFloat[0.1] = 'C';
$stringString = 'Foo';
$stringString['X'] = 'D';
$stringArray = 'Foo';
$stringArray[[]] = 'E';
die;
