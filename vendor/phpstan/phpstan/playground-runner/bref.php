<?php

declare (strict_types=1);
namespace RectorPrefix20210504;

require __DIR__ . '/vendor/autoload.php';
\error_reporting(\E_ALL);
\ini_set('display_errors', '1');
$client = new \RectorPrefix20210504\Raven_Client('https://35e1e4a8936c4b70b8377056a5eeaeeb@sentry.io/1319523');
$errorHandler = new \RectorPrefix20210504\Raven_ErrorHandler($client);
$errorHandler->registerExceptionHandler();
$errorHandler->registerErrorHandler();
$errorHandler->registerShutdownFunction();
function clearTemp() : void
{
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator('/tmp', \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $fileinfo) {
        $todo = $fileinfo->isDir() ? 'rmdir' : 'unlink';
        $todo($fileinfo->getRealPath());
    }
}
return function ($event) {
    \RectorPrefix20210504\clearTemp();
    $code = $event['code'];
    $level = $event['level'];
    $codePath = '/tmp/tmp.php';
    \file_put_contents($codePath, $code);
    $rootDir = \getenv('LAMBDA_TASK_ROOT');
    $configFiles = ['phar://' . $rootDir . '/vendor/phpstan/phpstan/phpstan.phar/conf/staticReflection.neon'];
    foreach (['strictRules' => $rootDir . '/vendor/phpstan/phpstan-strict-rules/rules.neon', 'bleedingEdge' => 'phar://' . $rootDir . '/vendor/phpstan/phpstan/phpstan.phar/conf/bleedingEdge.neon'] as $key => $file) {
        if (!isset($event[$key]) || !$event[$key]) {
            continue;
        }
        $configFiles[] = $file;
    }
    $finalConfigFile = '/tmp/run-phpstan-tmp.neon';
    $neon = \RectorPrefix20210504\Nette\Neon\Neon::encode(['includes' => $configFiles, 'parameters' => ['inferPrivatePropertyTypeFromConstructor' => \true, 'treatPhpDocTypesAsCertain' => $event['treatPhpDocTypesAsCertain'] ?? \true, 'phpVersion' => $event['phpVersion'] ?? 80000]]);
    \file_put_contents($finalConfigFile, $neon);
    require_once 'phar://' . $rootDir . '/vendor/phpstan/phpstan/phpstan.phar/stubs/runtime/ReflectionUnionType.php';
    $containerFactory = new \PHPStan\DependencyInjection\ContainerFactory('/tmp');
    $container = $containerFactory->create('/tmp', [\sprintf('%s/config.level%s.neon', $containerFactory->getConfigDirectory(), $level), $finalConfigFile], [$codePath]);
    /** @var \PHPStan\Analyser\Analyser $analyser */
    $analyser = $container->getByType(\PHPStan\Analyser\Analyser::class);
    $results = $analyser->analyse([$codePath], null, null, \false, [$codePath])->getErrors();
    \error_clear_last();
    $errors = [];
    foreach ($results as $result) {
        if (\is_string($result)) {
            $errors[] = ['message' => $result, 'line' => 1];
            continue;
        }
        $errors[] = ['message' => $result->getMessage(), 'line' => $result->getLine()];
    }
    return ['result' => $errors, 'version' => \RectorPrefix20210504\Jean85\PrettyVersions::getVersion('phpstan/phpstan')->getPrettyVersion()];
};
