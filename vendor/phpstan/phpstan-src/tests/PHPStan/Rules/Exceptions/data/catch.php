<?php

namespace _PhpScopera143bcca66cb\TestCatch;

class FooCatch
{
}
class MyCatchException extends \Exception
{
}
try {
} catch (\_PhpScopera143bcca66cb\TestCatch\FooCatch $e) {
    // not an exception
}
try {
} catch (\_PhpScopera143bcca66cb\TestCatch\MyCatchException $e) {
}
try {
} catch (\_PhpScopera143bcca66cb\FooCatchException $e) {
    // nonexistent exception class
}
try {
} catch (\TypeError $e) {
}
try {
} catch (\_PhpScopera143bcca66cb\TestCatch\MyCatchEXCEPTION $e) {
}
