<?php

namespace _PhpScoper88fe6e0ad041\InvalidKeyArrayItem;

/** @var string|\stdClass $stringOrObject */
$stringOrObject = doFoo();
$a = ['foo', 1 => 'aaa', '1' => 'aaa', null => 'aaa', new \DateTimeImmutable() => 'aaa', [] => 'bbb', $stringOrObject => 'aaa'];
