<?php

namespace _PhpScoperabd03f0baf05\TestCatch;

class FooCatch
{
}
class MyCatchException extends \Exception
{
}
try {
} catch (\_PhpScoperabd03f0baf05\TestCatch\FooCatch $e) {
    // not an exception
}
try {
} catch (\_PhpScoperabd03f0baf05\TestCatch\MyCatchException $e) {
}
try {
} catch (\_PhpScoperabd03f0baf05\FooCatchException $e) {
    // nonexistent exception class
}
try {
} catch (\TypeError $e) {
}
try {
} catch (\_PhpScoperabd03f0baf05\TestCatch\MyCatchEXCEPTION $e) {
}
