<?php

namespace _PhpScoper006a73f0e455\TestCatch;

class FooCatch
{
}
class MyCatchException extends \Exception
{
}
try {
} catch (\_PhpScoper006a73f0e455\TestCatch\FooCatch $e) {
    // not an exception
}
try {
} catch (\_PhpScoper006a73f0e455\TestCatch\MyCatchException $e) {
}
try {
} catch (\_PhpScoper006a73f0e455\FooCatchException $e) {
    // nonexistent exception class
}
try {
} catch (\TypeError $e) {
}
try {
} catch (\_PhpScoper006a73f0e455\TestCatch\MyCatchEXCEPTION $e) {
}
