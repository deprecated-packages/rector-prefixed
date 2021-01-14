<?php

declare (strict_types=1);
namespace Rector\Defluent\Tests\Rector\MethodCall\InArgChainFluentMethodCallToStandaloneMethodCallRectorTest\Source;

use RectorPrefix20210114\Nette\Utils\DateTime;
final class SetGetDateTime
{
    /**
     * @var DateTime|null
     */
    private $dateMin = null;
    public function setDateMin(?\RectorPrefix20210114\Nette\Utils\DateTime $dateTime = null)
    {
        $this->dateMin = $dateTime;
    }
    public function getDateMin() : ?\RectorPrefix20210114\Nette\Utils\DateTime
    {
        return $this->dateMin;
    }
}
