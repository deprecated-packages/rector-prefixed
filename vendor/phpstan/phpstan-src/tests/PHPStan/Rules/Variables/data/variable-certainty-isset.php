<?php

namespace _PhpScopera143bcca66cb;

function foo()
{
    /** @var string|null $alwaysDefinedNullable */
    $alwaysDefinedNullable = \_PhpScopera143bcca66cb\doFoo();
    if (isset($alwaysDefinedNullable)) {
        // fine, checking for nullability
    }
    $alwaysDefinedNotNullable = 'string';
    if (isset($alwaysDefinedNotNullable)) {
        // always true
    }
    if (\_PhpScopera143bcca66cb\doFoo()) {
        $sometimesDefinedVariable = 1;
    }
    if (isset($sometimesDefinedVariable, $neverDefinedVariable)) {
    }
    /** @var string|null $anotherAlwaysDefinedNullable */
    $anotherAlwaysDefinedNullable = \_PhpScopera143bcca66cb\doFoo();
    if (isset($anotherAlwaysDefinedNullable['test']['test'])) {
        // fine, checking for nullability
    }
    $anotherAlwaysDefinedNotNullable = 'string';
    if (isset($anotherAlwaysDefinedNotNullable['test']['test'])) {
        // fine, variable always exists, but what about the array index?
    }
    if (isset($anotherNeverDefinedVariable['test']['test']->test['test']['test'])) {
        // always false
    }
    if (isset($yetAnotherNeverDefinedVariable::$test['test'])) {
        // always false
    }
    if (isset($_COOKIE['test'])) {
        // fine
    }
    if (\_PhpScopera143bcca66cb\something()) {
    } elseif (isset($yetYetAnotherNeverDefinedVariableInIsset)) {
        // always false
    }
    if (\_PhpScopera143bcca66cb\doFoo()) {
        $yetAnotherVariableThatSometimesExists = 1;
    }
    if (\_PhpScopera143bcca66cb\something()) {
    } elseif (isset($yetAnotherVariableThatSometimesExists)) {
        // fine
    }
    /** @var string|null $nullableVariableUsedInTernary */
    $nullableVariableUsedInTernary = \_PhpScopera143bcca66cb\doFoo();
    echo isset($nullableVariableUsedInTernary) ? 'foo' : 'bar';
    // fine
    /** @var int|null $forVariableInit */
    $forVariableInit = \_PhpScopera143bcca66cb\doFoo();
    /** @var int|null $forVariableCond */
    $forVariableCond = \_PhpScopera143bcca66cb\doFoo();
    /** @var int|null $forVariableLoop */
    $forVariableLoop = \_PhpScopera143bcca66cb\doFoo();
    for ($i = 0, $init = isset($forVariableInit); $i < 10 && isset($forVariableCond); $i++, $loop = isset($forVariableLoop)) {
    }
    if (\_PhpScopera143bcca66cb\something()) {
        $variableInWhile = 1;
    }
    while (isset($variableInWhile)) {
        unset($variableInWhile);
    }
    if (\_PhpScopera143bcca66cb\something()) {
        $variableInDoWhile = 1;
    }
    do {
        $anotherVariableInDoWhile = 1;
        echo isset($yetAnotherVariableInDoWhile);
        // fine
    } while (isset($variableInDoWhile) && isset($anotherVariableInDoWhile) && ($yetAnotherVariableInDoWhile = 1));
    switch (\true) {
        case $variableInFirstCase = \true:
            isset($variableInSecondCase);
        // does not exist yet
        case $variableInSecondCase = \true:
            isset($variableInFirstCase);
            // always defined
            $variableAssignedInSecondCase = \true;
            break;
        case \_PhpScopera143bcca66cb\whatever():
            isset($variableInFirstCase);
            // always defined
            isset($variableInSecondCase);
            // always defined
            $variableInFallthroughCase = \true;
            isset($variableAssignedInSecondCase);
        // surely undefined
        case \_PhpScopera143bcca66cb\foo():
            isset($variableInFallthroughCase);
        // fine
        default:
    }
    if (\_PhpScopera143bcca66cb\foo()) {
        $mightBeUndefinedForSwitchCondition = 1;
        $mightBeUndefinedForCaseNodeCondition = 1;
    }
    switch (isset($mightBeUndefinedForSwitchCondition)) {
        // fine
        case isset($mightBeUndefinedForCaseNodeCondition):
            // fine
            break;
    }
    $alwaysDefinedForSwitchCondition = 1;
    $alwaysDefinedForCaseNodeCondition = 1;
    switch (isset($alwaysDefinedForSwitchCondition)) {
        case isset($alwaysDefinedForCaseNodeCondition):
            break;
    }
}
function () {
    $alwaysDefinedNotNullable = 'string';
    if (\_PhpScopera143bcca66cb\doFoo()) {
        $sometimesDefinedVariable = 1;
    }
    if (isset($alwaysDefinedNotNullable, $sometimesDefinedVariable, $neverDefinedVariable)) {
    }
};
function () {
    try {
        if (\_PhpScopera143bcca66cb\something()) {
            throw new \Exception();
        }
        $test = 'fooo';
    } finally {
        if (isset($test)) {
        }
    }
};
function () {
    /** @var string[] $strings */
    $strings = \_PhpScopera143bcca66cb\doFoo();
    foreach ($strings as $string) {
    }
    if (isset($string)) {
    }
};
function () {
    /** @var mixed $bar */
    $bar = $this->get('bar');
    if (isset($bar)) {
        $bar = (int) $bar;
    }
    if (isset($bar)) {
        echo $bar;
    }
};
function () {
    while (\true) {
        if (\rand() === 1) {
            $a = 'a';
            continue;
        }
        if (!isset($a)) {
            continue;
        }
        unset($a);
    }
};
function () {
    ($a = \rand(0, 5)) && \rand(0, 1);
    isset($a);
};
function () {
    \rand(0, 1) && ($a = \rand(0, 5));
    isset($a);
};
function () {
    $null = null;
    if (isset($null)) {
        // always false
    }
};
function () {
    isset($_SESSION);
    isset($_SESSION['foo']);
};
