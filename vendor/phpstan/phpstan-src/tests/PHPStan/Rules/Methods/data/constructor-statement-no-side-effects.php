<?php

namespace _PhpScopera143bcca66cb\ConstructorStatementNoSideEffects;

function () {
    new \Exception();
    throw new \Exception();
};
function () {
    new \PDOStatement();
    new \stdClass();
};
