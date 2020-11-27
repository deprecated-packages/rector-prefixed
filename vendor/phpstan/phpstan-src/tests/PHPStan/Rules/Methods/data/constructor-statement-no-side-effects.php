<?php

namespace _PhpScoper88fe6e0ad041\ConstructorStatementNoSideEffects;

function () {
    new \Exception();
    throw new \Exception();
};
function () {
    new \PDOStatement();
    new \stdClass();
};
