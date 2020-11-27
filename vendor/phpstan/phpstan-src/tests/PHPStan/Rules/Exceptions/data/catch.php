<?php

namespace _PhpScoper26e51eeacccf\TestCatch;

class FooCatch
{
}
class MyCatchException extends \Exception
{
}
try {
} catch (\_PhpScoper26e51eeacccf\TestCatch\FooCatch $e) {
    // not an exception
}
try {
} catch (\_PhpScoper26e51eeacccf\TestCatch\MyCatchException $e) {
}
try {
} catch (\_PhpScoper26e51eeacccf\FooCatchException $e) {
    // nonexistent exception class
}
try {
} catch (\TypeError $e) {
}
try {
} catch (\_PhpScoper26e51eeacccf\TestCatch\MyCatchEXCEPTION $e) {
}
