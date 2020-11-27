<?php

declare (strict_types=1);
namespace PHPStan\Command;

use PHPStan\Analyser\Error;
use PHPStan\Testing\TestCase;
final class AnalysisResultTest extends \PHPStan\Testing\TestCase
{
    public function testErrorsAreSortedByFileNameAndLine() : void
    {
        self::assertEquals([new \PHPStan\Analyser\Error('aa1', 'aaa'), new \PHPStan\Analyser\Error('aa2', 'aaa', 10), new \PHPStan\Analyser\Error('aa3', 'aaa', 15), new \PHPStan\Analyser\Error('aa4', 'aaa', 16), new \PHPStan\Analyser\Error('aa5', 'aaa', 16), new \PHPStan\Analyser\Error('aa6', 'aaa', 16), new \PHPStan\Analyser\Error('bb2', 'bbb', 2), new \PHPStan\Analyser\Error('bb1', 'bbb', 4), new \PHPStan\Analyser\Error('ccc', 'ccc'), new \PHPStan\Analyser\Error('ddd', 'ddd')], (new \PHPStan\Command\AnalysisResult([new \PHPStan\Analyser\Error('bb1', 'bbb', 4), new \PHPStan\Analyser\Error('bb2', 'bbb', 2), new \PHPStan\Analyser\Error('aa1', 'aaa'), new \PHPStan\Analyser\Error('ddd', 'ddd'), new \PHPStan\Analyser\Error('ccc', 'ccc'), new \PHPStan\Analyser\Error('aa2', 'aaa', 10), new \PHPStan\Analyser\Error('aa3', 'aaa', 15), new \PHPStan\Analyser\Error('aa5', 'aaa', 16), new \PHPStan\Analyser\Error('aa6', 'aaa', 16), new \PHPStan\Analyser\Error('aa4', 'aaa', 16)], [], [], [], \false, null, \true))->getFileSpecificErrors());
    }
}
