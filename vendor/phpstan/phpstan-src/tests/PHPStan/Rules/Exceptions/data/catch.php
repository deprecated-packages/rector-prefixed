<?php

namespace _PhpScoper88fe6e0ad041\TestCatch;

class FooCatch
{
}
class MyCatchException extends \Exception
{
}
try {
} catch (\_PhpScoper88fe6e0ad041\TestCatch\FooCatch $e) {
    // not an exception
}
try {
} catch (\_PhpScoper88fe6e0ad041\TestCatch\MyCatchException $e) {
}
try {
} catch (\_PhpScoper88fe6e0ad041\FooCatchException $e) {
    // nonexistent exception class
}
try {
} catch (\TypeError $e) {
}
try {
} catch (\_PhpScoper88fe6e0ad041\TestCatch\MyCatchEXCEPTION $e) {
}
