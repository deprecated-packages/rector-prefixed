<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Tests\Rector\MethodCall\ContextGetByTypeToConstructorInjectionRector\Source;

use _PhpScopere8e811afab72\Nette\Application\IPresenter;
use _PhpScopere8e811afab72\Nette\Application\IResponse;
use _PhpScopere8e811afab72\Nette\Application\Request;
class ParentWithInjectedPropertyPresenter implements \_PhpScopere8e811afab72\Nette\Application\IPresenter
{
    /**
     * @inject
     * @var SomeTypeToInject
     */
    public $someTypeToInject;
    function run(\_PhpScopere8e811afab72\Nette\Application\Request $request) : \_PhpScopere8e811afab72\Nette\Application\IResponse
    {
    }
}
