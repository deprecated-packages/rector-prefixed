<?php

namespace _PhpScoperabd03f0baf05\ConstructorStatementNoSideEffects;

function () {
    new \Exception();
    throw new \Exception();
};
function () {
    new \PDOStatement();
    new \stdClass();
};
