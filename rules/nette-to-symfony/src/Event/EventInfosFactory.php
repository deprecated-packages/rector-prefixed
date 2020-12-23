<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteToSymfony\Event;

use _PhpScoper0a2ac50786fa\Rector\NetteToSymfony\ValueObject\EventInfo;
final class EventInfosFactory
{
    /**
     * @return EventInfo[]
     */
    public function create() : array
    {
        $eventInfos = [];
        $eventInfos[] = new \_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\ValueObject\EventInfo(['nette.application.startup', 'nette.application.request'], ['Contributte\\Events\\Extra\\Event\\Application\\StartupEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\RequestEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_REQUEST', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_STARTUP'], '_PhpScoper0a2ac50786fa\\Symfony\\Component\\HttpKernel\\KernelEvents', 'REQUEST', '_PhpScoper0a2ac50786fa\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent');
        $eventInfos[] = new \_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\ValueObject\EventInfo(['nette.application.startup', 'nette.application.request'], ['Contributte\\Events\\Extra\\Event\\Application\\StartupEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\RequestEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_REQUEST', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_STARTUP'], '_PhpScoper0a2ac50786fa\\Symfony\\Component\\HttpKernel\\KernelEvents', 'REQUEST', '_PhpScoper0a2ac50786fa\\Symfony\\Component\\HttpKernel\\Event\\GetResponseEvent');
        $eventInfos[] = new \_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\ValueObject\EventInfo(['nette.application.presenter', 'nette.application.presenter.startup'], ['Contributte\\Events\\Extra\\Event\\Application\\PresenterEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\PresenterStartupEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\PresenterShutdownEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_PRESENTER_SHUTDOWN', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_PRESENTER_STARTUP', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_PRESENTER'], '_PhpScoper0a2ac50786fa\\Symfony\\Component\\HttpKernel\\KernelEvents', 'CONTROLLER', '_PhpScoper0a2ac50786fa\\Symfony\\Component\\HttpKernel\\Event\\FilterControllerEvent');
        $eventInfos[] = new \_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\ValueObject\EventInfo(['nette.application.error'], ['Contributte\\Events\\Extra\\Event\\Application\\ErrorEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_ERROR'], '_PhpScoper0a2ac50786fa\\Symfony\\Component\\HttpKernel\\KernelEvents', 'EXCEPTION', '_PhpScoper0a2ac50786fa\\Symfony\\Component\\HttpKernel\\Event\\GetResponseForExceptionEvent');
        $eventInfos[] = new \_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\ValueObject\EventInfo(['nette.application.response'], ['Contributte\\Events\\Extra\\Event\\Application\\ResponseEvent::NAME', 'Contributte\\Events\\Extra\\Event\\Application\\ApplicationEvents::ON_RESPONSE'], '_PhpScoper0a2ac50786fa\\Symfony\\Component\\HttpKernel\\KernelEvents', 'RESPONSE', '_PhpScoper0a2ac50786fa\\Symfony\\Component\\HttpKernel\\Event\\FilterResponseEvent');
        return $eventInfos;
    }
}
