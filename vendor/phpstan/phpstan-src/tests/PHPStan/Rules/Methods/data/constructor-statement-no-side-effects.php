<?php

namespace _PhpScoper26e51eeacccf\ConstructorStatementNoSideEffects;

function () {
    new \Exception();
    throw new \Exception();
};
function () {
    new \PDOStatement();
    new \stdClass();
};
