<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\MethodCall\NetteFormToSymfonyFormRector\Source;

use _PhpScoper5edc98a7cce2\Nette\Application\IPresenter;
use _PhpScoper5edc98a7cce2\Nette\Application\IResponse;
use _PhpScoper5edc98a7cce2\Nette\Application\Request;
abstract class NettePresenter implements \_PhpScoper5edc98a7cce2\Nette\Application\IPresenter
{
    public function run(\_PhpScoper5edc98a7cce2\Nette\Application\Request $request) : \_PhpScoper5edc98a7cce2\Nette\Application\IResponse
    {
    }
}
