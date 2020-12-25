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
        'Nette\\Application\\Application::onShutdown' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Application\\ShutdownEvent',
        'Nette\\Application\\Application::onStartup' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Application\\StartupEvent',
        'Nette\\Application\\Application::onError' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Application\\ErrorEvent',
        'Nette\\Application\\Application::onPresenter' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Application\\PresenterEvent',
        'Nette\\Application\\Application::onRequest' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Application\\RequestEvent',
        'Nette\\Application\\Application::onResponse' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Application\\ResponseEvent',
        // presenter
        'Nette\\Application\\UI\\Presenter::onStartup' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Application\\PresenterShutdownEvent',
        'Nette\\Application\\UI\\Presenter::onShutdown' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Application\\PresenterStartupEvent',
        // nette/security
        'Nette\\Security\\User::onLoggedIn' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Security\\LoggedInEvent',
        'Nette\\Security\\User::onLoggedOut' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Security\\LoggedOutEvent',
        // latte
        'Latte\\Engine::onCompile' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Latte\\LatteCompileEvent',
        'Nette\\Bridges\\ApplicationLatte\\TemplateFactory::onCreate' => '_PhpScoper8b9c402c5f32\\Contributte\\Events\\Extra\\Event\\Latte\\TemplateCreateEvent',
    ];
}
