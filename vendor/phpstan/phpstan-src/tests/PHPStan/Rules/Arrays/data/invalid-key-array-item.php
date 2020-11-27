<?php

namespace _PhpScoper006a73f0e455\InvalidKeyArrayItem;

/** @var string|\stdClass $stringOrObject */
$stringOrObject = doFoo();
$a = ['foo', 1 => 'aaa', '1' => 'aaa', null => 'aaa', new \DateTimeImmutable() => 'aaa', [] => 'bbb', $stringOrObject => 'aaa'];
