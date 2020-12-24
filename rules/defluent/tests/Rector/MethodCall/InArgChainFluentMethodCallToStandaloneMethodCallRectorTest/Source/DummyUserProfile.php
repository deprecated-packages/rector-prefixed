<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Tests\Rector\MethodCall\InArgChainFluentMethodCallToStandaloneMethodCallRectorTest\Source;

final class DummyUserProfile
{
    public function setOldDescription(string $description) : self
    {
        return $this;
    }
    public function setUserId($id) : self
    {
        $this->userId = $id;
        return $this;
    }
}
