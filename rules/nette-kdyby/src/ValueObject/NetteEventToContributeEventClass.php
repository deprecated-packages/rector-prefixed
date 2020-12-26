<?php

declare (strict_types=1);
namespace Rector\NetteKdyby\ValueObject;

final class NetteEventToContributeEventClass
{
    /**
     * @var string[]
     * @see https://github.com/contributte/event-dispatcher-extra/tree/master/src/Event
     */
    public const PROPERTY_TO_EVENT_CLASS = [
        // application
        'Nette\\Application\\Application::onShutdown' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Application\\ShutdownEvent',
        'Nette\\Application\\Application::onStartup' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Application\\StartupEvent',
        'Nette\\Application\\Application::onError' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Application\\ErrorEvent',
        'Nette\\Application\\Application::onPresenter' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Application\\PresenterEvent',
        'Nette\\Application\\Application::onRequest' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Application\\RequestEvent',
        'Nette\\Application\\Application::onResponse' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Application\\ResponseEvent',
        // presenter
        'Nette\\Application\\UI\\Presenter::onStartup' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Application\\PresenterShutdownEvent',
        'Nette\\Application\\UI\\Presenter::onShutdown' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Application\\PresenterStartupEvent',
        // nette/security
        'Nette\\Security\\User::onLoggedIn' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Security\\LoggedInEvent',
        'Nette\\Security\\User::onLoggedOut' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Security\\LoggedOutEvent',
        // latte
        'Latte\\Engine::onCompile' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Latte\\LatteCompileEvent',
        'Nette\\Bridges\\ApplicationLatte\\TemplateFactory::onCreate' => 'RectorPrefix2020DecSat\\Contributte\\Events\\Extra\\Event\\Latte\\TemplateCreateEvent',
    ];
}
