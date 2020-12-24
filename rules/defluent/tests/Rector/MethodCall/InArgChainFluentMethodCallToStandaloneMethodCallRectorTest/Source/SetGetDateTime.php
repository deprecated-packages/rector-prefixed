<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\Tests\Rector\MethodCall\InArgChainFluentMethodCallToStandaloneMethodCallRectorTest\Source;

use _PhpScopere8e811afab72\Nette\Utils\DateTime;
final class SetGetDateTime
{
    /**
     * @var DateTime|null
     */
    private $dateMin = null;
    public function setDateMin(?\_PhpScopere8e811afab72\Nette\Utils\DateTime $dateTime = null)
    {
        $this->dateMin = $dateTime;
    }
    public function getDateMin() : ?\_PhpScopere8e811afab72\Nette\Utils\DateTime
    {
        return $this->dateMin;
    }
}
