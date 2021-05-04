<?php

/**
 * This file is part of the Tracy (https://tracy.nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210504\Tracy\Bridges\Nette;

use RectorPrefix20210504\Nette;
use RectorPrefix20210504\Nette\Schema\Expect;
use RectorPrefix20210504\Tracy;
/**
 * Tracy extension for Nette DI.
 */
class TracyExtension extends \RectorPrefix20210504\Nette\DI\CompilerExtension
{
    /** @var bool */
    private $debugMode;
    /** @var bool */
    private $cliMode;
    public function __construct(bool $debugMode = \false, bool $cliMode = \false)
    {
        $this->debugMode = $debugMode;
        $this->cliMode = $cliMode;
    }
    public function getConfigSchema() : \RectorPrefix20210504\Nette\Schema\Schema
    {
        return \RectorPrefix20210504\Nette\Schema\Expect::structure(['email' => \RectorPrefix20210504\Nette\Schema\Expect::anyOf(\RectorPrefix20210504\Nette\Schema\Expect::email(), \RectorPrefix20210504\Nette\Schema\Expect::listOf('email'))->dynamic(), 'fromEmail' => \RectorPrefix20210504\Nette\Schema\Expect::email()->dynamic(), 'logSeverity' => \RectorPrefix20210504\Nette\Schema\Expect::anyOf(\RectorPrefix20210504\Nette\Schema\Expect::scalar(), \RectorPrefix20210504\Nette\Schema\Expect::listOf('scalar')), 'editor' => \RectorPrefix20210504\Nette\Schema\Expect::string()->dynamic(), 'browser' => \RectorPrefix20210504\Nette\Schema\Expect::string()->dynamic(), 'errorTemplate' => \RectorPrefix20210504\Nette\Schema\Expect::string()->dynamic(), 'strictMode' => \RectorPrefix20210504\Nette\Schema\Expect::bool()->dynamic(), 'showBar' => \RectorPrefix20210504\Nette\Schema\Expect::bool()->dynamic(), 'maxLength' => \RectorPrefix20210504\Nette\Schema\Expect::int()->dynamic(), 'maxDepth' => \RectorPrefix20210504\Nette\Schema\Expect::int()->dynamic(), 'keysToHide' => \RectorPrefix20210504\Nette\Schema\Expect::array(null)->dynamic(), 'dumpTheme' => \RectorPrefix20210504\Nette\Schema\Expect::string()->dynamic(), 'showLocation' => \RectorPrefix20210504\Nette\Schema\Expect::bool()->dynamic(), 'scream' => \RectorPrefix20210504\Nette\Schema\Expect::bool()->dynamic(), 'bar' => \RectorPrefix20210504\Nette\Schema\Expect::listOf('RectorPrefix20210504\\string|Nette\\DI\\Definitions\\Statement'), 'blueScreen' => \RectorPrefix20210504\Nette\Schema\Expect::listOf('callable'), 'editorMapping' => \RectorPrefix20210504\Nette\Schema\Expect::arrayOf('string')->dynamic()->default(null), 'netteMailer' => \RectorPrefix20210504\Nette\Schema\Expect::bool(\true)]);
    }
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $builder->addDefinition($this->prefix('logger'))->setClass(\RectorPrefix20210504\Tracy\ILogger::class)->setFactory([\RectorPrefix20210504\Tracy\Debugger::class, 'getLogger']);
        $builder->addDefinition($this->prefix('blueScreen'))->setFactory([\RectorPrefix20210504\Tracy\Debugger::class, 'getBlueScreen']);
        $builder->addDefinition($this->prefix('bar'))->setFactory([\RectorPrefix20210504\Tracy\Debugger::class, 'getBar']);
    }
    public function afterCompile(\RectorPrefix20210504\Nette\PhpGenerator\ClassType $class)
    {
        $initialize = $this->initialization ?? new \RectorPrefix20210504\Nette\PhpGenerator\Closure();
        $initialize->addBody('if (!Tracy\\Debugger::isEnabled()) { return; }');
        $builder = $this->getContainerBuilder();
        $options = (array) $this->config;
        unset($options['bar'], $options['blueScreen'], $options['netteMailer']);
        if (isset($options['logSeverity'])) {
            $res = 0;
            foreach ((array) $options['logSeverity'] as $level) {
                $res |= \is_int($level) ? $level : \constant($level);
            }
            $options['logSeverity'] = $res;
        }
        foreach ($options as $key => $value) {
            if ($value !== null) {
                static $tbl = ['keysToHide' => 'array_push(Tracy\\Debugger::getBlueScreen()->keysToHide, ... ?)', 'fromEmail' => 'Tracy\\Debugger::getLogger()->fromEmail = ?'];
                $initialize->addBody($builder->formatPhp(($tbl[$key] ?? 'Tracy\\Debugger::$' . $key . ' = ?') . ';', \RectorPrefix20210504\Nette\DI\Helpers::filterArguments([$value])));
            }
        }
        $logger = $builder->getDefinition($this->prefix('logger'));
        if (!$logger instanceof \RectorPrefix20210504\Nette\DI\ServiceDefinition || $logger->getFactory()->getEntity() !== [\RectorPrefix20210504\Tracy\Debugger::class, 'getLogger']) {
            $initialize->addBody($builder->formatPhp('Tracy\\Debugger::setLogger(?);', [$logger]));
        }
        if ($this->config->netteMailer && $builder->getByType(\RectorPrefix20210504\Nette\Mail\IMailer::class)) {
            $initialize->addBody($builder->formatPhp('Tracy\\Debugger::getLogger()->mailer = ?;', [[new \RectorPrefix20210504\Nette\DI\Statement(\RectorPrefix20210504\Tracy\Bridges\Nette\MailSender::class, ['fromEmail' => $this->config->fromEmail]), 'send']]));
        }
        if ($this->debugMode) {
            foreach ($this->config->bar as $item) {
                if (\is_string($item) && \substr($item, 0, 1) === '@') {
                    $item = new \RectorPrefix20210504\Nette\DI\Statement(['@' . $builder::THIS_CONTAINER, 'getService'], [\substr($item, 1)]);
                } elseif (\is_string($item)) {
                    $item = new \RectorPrefix20210504\Nette\DI\Statement($item);
                }
                $initialize->addBody($builder->formatPhp('$this->getService(?)->addPanel(?);', \RectorPrefix20210504\Nette\DI\Helpers::filterArguments([$this->prefix('bar'), $item])));
            }
            if (!$this->cliMode && ($name = $builder->getByType(\RectorPrefix20210504\Nette\Http\Session::class))) {
                $initialize->addBody('$this->getService(?)->start();', [$name]);
                $initialize->addBody('Tracy\\Debugger::dispatch();');
            }
        }
        foreach ($this->config->blueScreen as $item) {
            $initialize->addBody($builder->formatPhp('$this->getService(?)->addPanel(?);', \RectorPrefix20210504\Nette\DI\Helpers::filterArguments([$this->prefix('blueScreen'), $item])));
        }
        if (empty($this->initialization)) {
            $class->getMethod('initialize')->addBody("({$initialize})();");
        }
        if (($dir = \RectorPrefix20210504\Tracy\Debugger::$logDirectory) && !\is_writable($dir)) {
            throw new \RectorPrefix20210504\Nette\InvalidStateException("Make directory '{$dir}' writable.");
        }
    }
}
