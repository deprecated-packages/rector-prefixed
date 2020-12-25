<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScoper5edc98a7cce2\Nette\Application\IPresenter;
use _PhpScoper5edc98a7cce2\Nette\Application\IResponse;
use _PhpScoper5edc98a7cce2\Nette\Application\Request;
class ConstructorInjectionParentPresenter implements \_PhpScoper5edc98a7cce2\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    private $someTypeToInject;
    public function __construct(\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScoper5edc98a7cce2\Nette\Application\Request $request) : \_PhpScoper5edc98a7cce2\Nette\Application\IResponse
    {
    }
}
