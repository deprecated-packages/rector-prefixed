<?php

namespace _PhpScoperbd5d0c5f7638\TestCatch;

class FooCatch
{
}
class MyCatchException extends \Exception
{
}
try {
} catch (\_PhpScoperbd5d0c5f7638\TestCatch\FooCatch $e) {
    // not an exception
}
try {
} catch (\_PhpScoperbd5d0c5f7638\TestCatch\MyCatchException $e) {
}
try {
} catch (\_PhpScoperbd5d0c5f7638\FooCatchException $e) {
    // nonexistent exception class
}
try {
} catch (\TypeError $e) {
}
try {
} catch (\_PhpScoperbd5d0c5f7638\TestCatch\MyCatchEXCEPTION $e) {
}
