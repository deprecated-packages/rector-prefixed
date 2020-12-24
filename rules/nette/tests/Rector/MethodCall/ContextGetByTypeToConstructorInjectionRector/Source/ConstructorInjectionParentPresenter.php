<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScopere8e811afab72\Nette\Application\IPresenter;
use _PhpScopere8e811afab72\Nette\Application\IResponse;
use _PhpScopere8e811afab72\Nette\Application\Request;
class ConstructorInjectionParentPresenter implements \_PhpScopere8e811afab72\Nette\Application\IPresenter
{
    /**
     * @var SomeTypeToInject
     */
    private $someTypeToInject;
    public function __construct(\_PhpScopere8e811afab72\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source\SomeTypeToInject $someTypeToInject)
    {
        $this->someTypeToInject = $someTypeToInject;
    }
    function run(\_PhpScopere8e811afab72\Nette\Application\Request $request) : \_PhpScopere8e811afab72\Nette\Application\IResponse
    {
    }
}
