<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Event;

use Rector\NetteToSymfony\ValueObject\EventInfo;
final class EventInfosFactory
{
    /**
     * @return EventInfo[]
     */
    public function create() : array
    {
        $eventInfos = [];
        $eventInfos[] = new \Rector\NetteToSymfony\ValueObject\EventInfo(['nette.application.startup', 'nette.application.request'], ['Contributte\\Events\\Extra\\Event\\Application\\StartupEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\RequestEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_REQUEST', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_STARTUP'], '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\KernelEvents', 'REQUEST', '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent');
        $eventInfos[] = new \Rector\NetteToSymfony\ValueObject\EventInfo(['nette.application.startup', 'nette.application.request'], ['Contributte\\Events\\Extra\\Event\\Application\\StartupEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\RequestEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_REQUEST', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_STARTUP'], '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\KernelEvents', 'REQUEST', '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent');
        $eventInfos[] = new \Rector\NetteToSymfony\ValueObject\EventInfo(['nette.application.presenter', 'nette.application.presenter.startup'], ['Contributte\\Events\\Extra\\Event\\Application\\PresenterEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\PresenterStartupEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\PresenterShutdownEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_PRESENTER_SHUTDOWN', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_PRESENTER_STARTUP', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_PRESENTER'], '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\KernelEvents', 'CONTROLLER', '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent');
        $eventInfos[] = new \Rector\NetteToSymfony\ValueObject\EventInfo(['nette.application.error'], ['Contributte\\Events\\Extra\\Event\\Application\\ErrorEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_ERROR'], '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\KernelEvents', 'EXCEPTION', '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent');
        $eventInfos[] = new \Rector\NetteToSymfony\ValueObject\EventInfo(['nette.application.response'], ['Contributte\\Events\\Extra\\Event\\Application\\ResponseEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_RESPONSE'], '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\KernelEvents', 'RESPONSE', '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent');
        return $eventInfos;
    }
}
