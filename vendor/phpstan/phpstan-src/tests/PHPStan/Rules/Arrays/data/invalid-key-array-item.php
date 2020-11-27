<?php

namespace _PhpScoperbd5d0c5f7638\InvalidKeyArrayItem;

/** @var string|\stdClass $stringOrObject */
$stringOrObject = doFoo();
$a = ['foo', 1 => 'aaa', '1' => 'aaa', null => 'aaa', new \DateTimeImmutable() => 'aaa', [] => 'bbb', $stringOrObject => 'aaa'];
