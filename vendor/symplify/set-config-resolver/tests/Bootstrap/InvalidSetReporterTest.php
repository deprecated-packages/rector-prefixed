<?php

declare (strict_types=1);
namespace RectorPrefix20210306\Symplify\SetConfigResolver\Tests\Bootstrap;

use RectorPrefix20210306\PHPUnit\Framework\TestCase;
use RectorPrefix20210306\Symplify\SetConfigResolver\Bootstrap\InvalidSetReporter;
use RectorPrefix20210306\Symplify\SetConfigResolver\Exception\SetNotFoundException;
final class InvalidSetReporterTest extends \RectorPrefix20210306\PHPUnit\Framework\TestCase
{
    /**
     * @var InvalidSetReporter
     */
    private $invalidSetReporter;
    protected function setUp() : void
    {
        $this->invalidSetReporter = new \RectorPrefix20210306\Symplify\SetConfigResolver\Bootstrap\InvalidSetReporter();
    }
    /**
     * @doesNotPerformAssertions
     */
    public function test() : void
    {
        $setNotFoundException = new \RectorPrefix20210306\Symplify\SetConfigResolver\Exception\SetNotFoundException('not found', 'one', ['two', 'three']);
        $this->invalidSetReporter->report($setNotFoundException);
    }
}
