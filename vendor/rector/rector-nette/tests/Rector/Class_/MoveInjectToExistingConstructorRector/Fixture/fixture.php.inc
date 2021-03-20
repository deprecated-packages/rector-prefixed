<?php

namespace Rector\Nette\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Fixture;

use Rector\Nette\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Source\OtherDependency;
use Rector\Nette\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Source\SomeDependency;

final class Fixture
{
    /**
     * @var SomeDependency
     * @inject
     */
    public $someDependency;

    /**
     * @var OtherDependency
     */
    private $otherDependency;

    public function __construct(OtherDependency $otherDependency)
    {
        $this->otherDependency = $otherDependency;
    }
}

?>
-----
<?php

namespace Rector\Nette\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Fixture;

use Rector\Nette\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Source\OtherDependency;
use Rector\Nette\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Source\SomeDependency;

final class Fixture
{
    /**
     * @var OtherDependency
     */
    private $otherDependency;

    public function __construct(OtherDependency $otherDependency, private \Rector\Nette\Tests\Rector\Class_\MoveInjectToExistingConstructorRector\Source\SomeDependency $someDependency)
    {
        $this->otherDependency = $otherDependency;
    }
}

?>
