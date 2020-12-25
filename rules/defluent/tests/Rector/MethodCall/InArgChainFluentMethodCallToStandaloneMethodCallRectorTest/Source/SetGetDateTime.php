<?php

declare (strict_types=1);
namespace Rector\Defluent\Tests\Rector\MethodCall\InArgChainFluentMethodCallToStandaloneMethodCallRectorTest\Source;

use _PhpScoperbf340cb0be9d\Nette\Utils\DateTime;
final class SetGetDateTime
{
    /**
     * @var DateTime|null
     */
    private $dateMin = null;
    public function setDateMin(?\_PhpScoperbf340cb0be9d\Nette\Utils\DateTime $dateTime = null)
    {
        $this->dateMin = $dateTime;
    }
    public function getDateMin() : ?\_PhpScoperbf340cb0be9d\Nette\Utils\DateTime
    {
        return $this->dateMin;
    }
}
