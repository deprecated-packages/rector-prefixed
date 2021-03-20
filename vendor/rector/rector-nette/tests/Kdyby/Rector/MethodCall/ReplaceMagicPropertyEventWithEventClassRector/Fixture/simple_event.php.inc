<?php

namespace Rector\Nette\Tests\Kdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Fixture;

use Rector\Nette\Tests\Kdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Source\SomeUser;

final class FileManager
{
    public $onUpload;

    public function run(SomeUser $user)
    {
        $this->onUpload($user);
    }
}

?>
-----
<?php

namespace Rector\Nette\Tests\Kdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Fixture;

use Rector\Nette\Tests\Kdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Source\SomeUser;

final class FileManager
{
    public function __construct(private \Symfony\Contracts\EventDispatcher\EventDispatcherInterface $eventDispatcher)
    {
    }

    public function run(SomeUser $user)
    {
        $fileManagerUploadEvent = new \Rector\Nette\Tests\Kdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Fixture\Event\FileManagerUploadEvent($user);
        $this->eventDispatcher->dispatch($fileManagerUploadEvent);
    }
}

?>
