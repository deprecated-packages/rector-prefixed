<?php

namespace _PhpScoper26e51eeacccf\Bug2863;

use function PHPStan\Analyser\assertType;
$result = \json_decode('{"a":5}');
\PHPStan\Analyser\assertType('int', \json_last_error());
\PHPStan\Analyser\assertType('string', \json_last_error_msg());
if (\json_last_error() !== \JSON_ERROR_NONE || \json_last_error_msg() !== 'No error') {
    throw new \_PhpScoper26e51eeacccf\Bug2863\Exception(\json_last_error_msg());
}
\PHPStan\Analyser\assertType('0', \json_last_error());
\PHPStan\Analyser\assertType("'No error'", \json_last_error_msg());
//
$result2 = \json_decode('');
\PHPStan\Analyser\assertType('int', \json_last_error());
\PHPStan\Analyser\assertType('string', \json_last_error_msg());
if (\json_last_error() !== \JSON_ERROR_NONE || \json_last_error_msg() !== 'No error') {
    throw new \_PhpScoper26e51eeacccf\Bug2863\Exception(\json_last_error_msg());
}
\PHPStan\Analyser\assertType('0', \json_last_error());
\PHPStan\Analyser\assertType("'No error'", \json_last_error_msg());
//
$result3 = \json_encode([]);
\PHPStan\Analyser\assertType('int', \json_last_error());
\PHPStan\Analyser\assertType('string', \json_last_error_msg());
if (\json_last_error() !== \JSON_ERROR_NONE || \json_last_error_msg() !== 'No error') {
    throw new \_PhpScoper26e51eeacccf\Bug2863\Exception(\json_last_error_msg());
}
\PHPStan\Analyser\assertType('0', \json_last_error());
\PHPStan\Analyser\assertType("'No error'", \json_last_error_msg());
