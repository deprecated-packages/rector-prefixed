<?php

declare (strict_types=1);
namespace PHPStan\Command;

use _PhpScoper88fe6e0ad041\Clue\React\NDJson\Decoder;
use _PhpScoper88fe6e0ad041\Clue\React\NDJson\Encoder;
use _PhpScoper88fe6e0ad041\Composer\CaBundle\CaBundle;
use _PhpScoper88fe6e0ad041\Nette\Utils\Json;
use Phar;
use PHPStan\Analyser\AnalyserResult;
use PHPStan\Analyser\IgnoredErrorHelper;
use PHPStan\Analyser\ResultCache\ResultCacheClearer;
use PHPStan\Analyser\ResultCache\ResultCacheManagerFactory;
use PHPStan\File\FileMonitor;
use PHPStan\File\FileMonitorResult;
use PHPStan\File\FileReader;
use PHPStan\File\FileWriter;
use PHPStan\Parallel\Scheduler;
use PHPStan\Process\CpuCoreCounter;
use PHPStan\Process\ProcessHelper;
use PHPStan\Process\ProcessPromise;
use PHPStan\Process\Runnable\RunnableQueue;
use PHPStan\Process\Runnable\RunnableQueueLogger;
use _PhpScoper88fe6e0ad041\Psr\Http\Message\ResponseInterface;
use _PhpScoper88fe6e0ad041\React\ChildProcess\Process;
use _PhpScoper88fe6e0ad041\React\EventLoop\LoopInterface;
use _PhpScoper88fe6e0ad041\React\EventLoop\StreamSelectLoop;
use _PhpScoper88fe6e0ad041\React\Http\Browser;
use _PhpScoper88fe6e0ad041\React\Promise\CancellablePromiseInterface;
use _PhpScoper88fe6e0ad041\React\Promise\ExtendedPromiseInterface;
use _PhpScoper88fe6e0ad041\React\Promise\PromiseInterface;
use _PhpScoper88fe6e0ad041\React\Socket\ConnectionInterface;
use _PhpScoper88fe6e0ad041\React\Socket\Connector;
use _PhpScoper88fe6e0ad041\Symfony\Component\Console\Helper\ProgressBar;
use _PhpScoper88fe6e0ad041\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper88fe6e0ad041\Symfony\Component\Console\Output\OutputInterface;
use const PHP_BINARY;
use function _PhpScoper88fe6e0ad041\Clue\React\Block\await;
use function escapeshellarg;
use function file_exists;
use function _PhpScoper88fe6e0ad041\React\Promise\resolve;
class FixerApplication
{
    /** @var FileMonitor */
    private $fileMonitor;
    /** @var ResultCacheManagerFactory */
    private $resultCacheManagerFactory;
    /** @var ResultCacheClearer */
    private $resultCacheClearer;
    /** @var IgnoredErrorHelper */
    private $ignoredErrorHelper;
    /** @var CpuCoreCounter */
    private $cpuCoreCounter;
    /** @var Scheduler */
    private $scheduler;
    /** @var string[] */
    private $analysedPaths;
    /** @var (ExtendedPromiseInterface&CancellablePromiseInterface|null) */
    private $processInProgress;
    /** @var string */
    private $currentWorkingDirectory;
    /** @var string */
    private $fixerTmpDir;
    /**
     * @var int
     */
    private $maximumNumberOfProcesses;
    /** @var string|null */
    private $fixerSuggestionId;
    /**
     * @param FileMonitor $fileMonitor
     * @param ResultCacheManagerFactory $resultCacheManagerFactory
     * @param string[] $analysedPaths
     */
    public function __construct(\PHPStan\File\FileMonitor $fileMonitor, \PHPStan\Analyser\ResultCache\ResultCacheManagerFactory $resultCacheManagerFactory, \PHPStan\Analyser\ResultCache\ResultCacheClearer $resultCacheClearer, \PHPStan\Analyser\IgnoredErrorHelper $ignoredErrorHelper, \PHPStan\Process\CpuCoreCounter $cpuCoreCounter, \PHPStan\Parallel\Scheduler $scheduler, array $analysedPaths, string $currentWorkingDirectory, string $fixerTmpDir, int $maximumNumberOfProcesses)
    {
        $this->fileMonitor = $fileMonitor;
        $this->resultCacheManagerFactory = $resultCacheManagerFactory;
        $this->resultCacheClearer = $resultCacheClearer;
        $this->ignoredErrorHelper = $ignoredErrorHelper;
        $this->cpuCoreCounter = $cpuCoreCounter;
        $this->scheduler = $scheduler;
        $this->analysedPaths = $analysedPaths;
        $this->currentWorkingDirectory = $currentWorkingDirectory;
        $this->fixerTmpDir = $fixerTmpDir;
        $this->maximumNumberOfProcesses = $maximumNumberOfProcesses;
    }
    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \PHPStan\Analyser\Error[] $fileSpecificErrors
     * @param string[] $notFileSpecificErrors
     * @return int
     */
    public function run(?string $projectConfigFile, \PHPStan\Command\InceptionResult $inceptionResult, \_PhpScoper88fe6e0ad041\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper88fe6e0ad041\Symfony\Component\Console\Output\OutputInterface $output, array $fileSpecificErrors, array $notFileSpecificErrors, int $filesCount, string $mainScript) : int
    {
        $loop = new \_PhpScoper88fe6e0ad041\React\EventLoop\StreamSelectLoop();
        $server = new \_PhpScoper88fe6e0ad041\React\Socket\TcpServer('127.0.0.1:0', $loop);
        /** @var string $serverAddress */
        $serverAddress = $server->getAddress();
        /** @var int $serverPort */
        $serverPort = \parse_url($serverAddress, \PHP_URL_PORT);
        $reanalyseProcessQueue = new \PHPStan\Process\Runnable\RunnableQueue(new class implements \PHPStan\Process\Runnable\RunnableQueueLogger
        {
            public function log(string $message) : void
            {
            }
        }, \min($this->cpuCoreCounter->getNumberOfCpuCores(), $this->maximumNumberOfProcesses));
        $server->on('connection', function (\_PhpScoper88fe6e0ad041\React\Socket\ConnectionInterface $connection) use($loop, $projectConfigFile, $input, $output, $fileSpecificErrors, $notFileSpecificErrors, $mainScript, $filesCount, $reanalyseProcessQueue, $inceptionResult) : void {
            $decoder = new \_PhpScoper88fe6e0ad041\Clue\React\NDJson\Decoder($connection, \true, 512, \defined('JSON_INVALID_UTF8_IGNORE') ? \JSON_INVALID_UTF8_IGNORE : 0, 128 * 1024 * 1024);
            $encoder = new \_PhpScoper88fe6e0ad041\Clue\React\NDJson\Encoder($connection, \defined('JSON_INVALID_UTF8_IGNORE') ? \JSON_INVALID_UTF8_IGNORE : 0);
            $encoder->write(['action' => 'initialData', 'data' => ['fileSpecificErrors' => $fileSpecificErrors, 'notFileSpecificErrors' => $notFileSpecificErrors, 'currentWorkingDirectory' => $this->currentWorkingDirectory, 'analysedPaths' => $this->analysedPaths, 'projectConfigFile' => $projectConfigFile, 'filesCount' => $filesCount, 'phpstanVersion' => $this->getPhpstanVersion()]]);
            $decoder->on('data', function (array $data) use($loop, $encoder, $projectConfigFile, $input, $output, $mainScript, $reanalyseProcessQueue, $inceptionResult) : void {
                if ($data['action'] === 'webPort') {
                    $output->writeln(\sprintf('Open your web browser at: <fg=cyan>http://127.0.0.1:%d</>', $data['data']['port']));
                    $output->writeln('Press [Ctrl-C] to quit.');
                    return;
                }
                if ($data['action'] === 'restoreResultCache') {
                    $this->fixerSuggestionId = $data['data']['fixerSuggestionId'];
                }
                if ($data['action'] !== 'reanalyse') {
                    return;
                }
                $id = $data['id'];
                $this->reanalyseWithTmpFile($loop, $inceptionResult, $mainScript, $reanalyseProcessQueue, $projectConfigFile, $data['data']['tmpFile'], $data['data']['insteadOfFile'], $data['data']['fixerSuggestionId'], $input)->done(static function (string $output) use($encoder, $id) : void {
                    $encoder->write(['id' => $id, 'response' => \_PhpScoper88fe6e0ad041\Nette\Utils\Json::decode($output, \_PhpScoper88fe6e0ad041\Nette\Utils\Json::FORCE_ARRAY)]);
                }, static function (\Throwable $e) use($encoder, $id, $output) : void {
                    if ($e instanceof \PHPStan\Process\ProcessCrashedException) {
                        $output->writeln('<error>Worker process exited: ' . $e->getMessage() . '</error>');
                        $encoder->write(['id' => $id, 'error' => $e->getMessage()]);
                        return;
                    }
                    if ($e instanceof \PHPStan\Process\ProcessCanceledException) {
                        $encoder->write(['id' => $id, 'error' => $e->getMessage()]);
                        return;
                    }
                    $output->writeln('<error>Unexpected error: ' . $e->getMessage() . '</error>');
                    $encoder->write(['id' => $id, 'error' => $e->getMessage()]);
                });
            });
            $this->fileMonitor->initialize($this->analysedPaths);
            $this->monitorFileChanges($loop, function (\PHPStan\File\FileMonitorResult $changes) use($loop, $mainScript, $projectConfigFile, $input, $encoder, $output, $reanalyseProcessQueue, $inceptionResult) : void {
                $reanalyseProcessQueue->cancelAll();
                if ($this->processInProgress !== null) {
                    $this->processInProgress->cancel();
                    $this->processInProgress = null;
                } else {
                    $encoder->write(['action' => 'analysisStart']);
                }
                $this->reanalyseAfterFileChanges($loop, $inceptionResult, $mainScript, $projectConfigFile, $this->fixerSuggestionId, $input)->done(function (array $json) use($encoder, $changes) : void {
                    $this->processInProgress = null;
                    $this->fixerSuggestionId = null;
                    $encoder->write(['action' => 'analysisEnd', 'data' => ['fileSpecificErrors' => $json['fileSpecificErrors'], 'notFileSpecificErrors' => $json['notFileSpecificErrors'], 'filesCount' => $changes->getTotalFilesCount()]]);
                    $this->resultCacheClearer->clearTemporaryCaches();
                }, function (\Throwable $e) use($encoder, $output) : void {
                    $this->processInProgress = null;
                    $this->fixerSuggestionId = null;
                    $output->writeln('<error>Worker process exited: ' . $e->getMessage() . '</error>');
                    $encoder->write(['action' => 'analysisCrash', 'data' => ['error' => $e->getMessage()]]);
                });
            });
        });
        try {
            $fixerProcess = $this->getFixerProcess($output, $serverPort);
        } catch (\PHPStan\Command\FixerProcessException $e) {
            return 1;
        }
        $fixerProcess->start($loop);
        $fixerProcess->on('exit', static function ($exitCode) use($output, $loop) : void {
            $loop->stop();
            if ($exitCode === null) {
                return;
            }
            if ($exitCode === 0) {
                return;
            }
            $output->writeln(\sprintf('<fg=red>PHPStan Pro process exited with code %d.</>', $exitCode));
        });
        $loop->run();
        return 0;
    }
    private function getFixerProcess(\_PhpScoper88fe6e0ad041\Symfony\Component\Console\Output\OutputInterface $output, int $serverPort) : \_PhpScoper88fe6e0ad041\React\ChildProcess\Process
    {
        if (!@\mkdir($this->fixerTmpDir, 0777) && !\is_dir($this->fixerTmpDir)) {
            $output->writeln(\sprintf('Cannot create a temp directory %s', $this->fixerTmpDir));
            throw new \PHPStan\Command\FixerProcessException();
        }
        $pharPath = $this->fixerTmpDir . '/phpstan-fixer.phar';
        $infoPath = $this->fixerTmpDir . '/phar-info.json';
        try {
            $this->downloadPhar($output, $pharPath, $infoPath);
        } catch (\RuntimeException $e) {
            if (!\file_exists($pharPath)) {
                $output->writeln('<fg=red>Could not download the PHPStan Pro executable.</>');
                $output->writeln($e->getMessage());
                throw new \PHPStan\Command\FixerProcessException();
            }
        }
        $pubKeyPath = $pharPath . '.pubkey';
        \PHPStan\File\FileWriter::write($pubKeyPath, \PHPStan\File\FileReader::read(__DIR__ . '/fixer-phar.pubkey'));
        try {
            $phar = new \Phar($pharPath);
        } catch (\Throwable $e) {
            @\unlink($pharPath);
            @\unlink($infoPath);
            $output->writeln('<fg=red>PHPStan Pro PHAR signature is corrupted.</>');
            throw new \PHPStan\Command\FixerProcessException();
        }
        if ($phar->getSignature()['hash_type'] !== 'OpenSSL') {
            @\unlink($pharPath);
            @\unlink($infoPath);
            $output->writeln('<fg=red>PHPStan Pro PHAR signature is corrupted.</>');
            throw new \PHPStan\Command\FixerProcessException();
        }
        $env = null;
        $forcedPort = $_SERVER['PHPSTAN_PRO_WEB_PORT'] ?? null;
        if ($forcedPort !== null) {
            $env['PHPSTAN_PRO_WEB_PORT'] = $_SERVER['PHPSTAN_PRO_WEB_PORT'];
            $isDocker = $this->isDockerRunning();
            if ($isDocker) {
                $output->writeln('Running in Docker? Don\'t forget to do these steps:');
                $output->writeln('1) Publish this port when running Docker:');
                $output->writeln(\sprintf('   <fg=cyan>-p 127.0.0.1:%d:%d</>', $_SERVER['PHPSTAN_PRO_WEB_PORT'], $_SERVER['PHPSTAN_PRO_WEB_PORT']));
                $output->writeln('2) Map the temp directory to a persistent volume');
                $output->writeln('   so that you don\'t have to log in every time:');
                $output->writeln(\sprintf('   <fg=cyan>-v ~/.phpstan-pro:%s</>', $this->fixerTmpDir));
                $output->writeln('');
            }
        } else {
            $isDocker = $this->isDockerRunning();
            if ($isDocker) {
                $output->writeln('Running in Docker? You need to do these steps in order to launch PHPStan Pro:');
                $output->writeln('');
                $output->writeln('1) Set the PHPSTAN_PRO_WEB_PORT environment variable in the Dockerfile:');
                $output->writeln('   <fg=cyan>ENV PHPSTAN_PRO_WEB_PORT=11111</>');
                $output->writeln('2) Expose this port in the Dockerfile:');
                $output->writeln('   <fg=cyan>EXPOSE 11111</>');
                $output->writeln('3) Publish this port when running Docker:');
                $output->writeln('   <fg=cyan>-p 127.0.0.1:11111:11111</>');
                $output->writeln('4) Map the temp directory to a persistent volume');
                $output->writeln('   so that you don\'t have to log in every time:');
                $output->writeln(\sprintf('   <fg=cyan>-v ~/phpstan-pro:%s</>', $this->fixerTmpDir));
                $output->writeln('');
            }
        }
        return new \_PhpScoper88fe6e0ad041\React\ChildProcess\Process(\sprintf('%s -d memory_limit=%s %s --port %d', \PHP_BINARY, \escapeshellarg(\ini_get('memory_limit')), \escapeshellarg($pharPath), $serverPort), null, $env, []);
    }
    private function downloadPhar(\_PhpScoper88fe6e0ad041\Symfony\Component\Console\Output\OutputInterface $output, string $pharPath, string $infoPath) : void
    {
        $currentVersion = null;
        if (\file_exists($pharPath) && \file_exists($infoPath)) {
            /** @var array{version: string, date: string} $currentInfo */
            $currentInfo = \_PhpScoper88fe6e0ad041\Nette\Utils\Json::decode(\PHPStan\File\FileReader::read($infoPath), \_PhpScoper88fe6e0ad041\Nette\Utils\Json::FORCE_ARRAY);
            $currentVersion = $currentInfo['version'];
            $currentDate = \DateTime::createFromFormat(\DateTime::ATOM, $currentInfo['date']);
            if ($currentDate === \false) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            if (new \DateTimeImmutable('', new \DateTimeZone('UTC')) <= $currentDate->modify('+24 hours')) {
                return;
            }
            $output->writeln('<fg=green>Checking if there\'s a new PHPStan Pro release...</>');
        }
        $loop = new \_PhpScoper88fe6e0ad041\React\EventLoop\StreamSelectLoop();
        $client = new \_PhpScoper88fe6e0ad041\React\Http\Browser($loop, new \_PhpScoper88fe6e0ad041\React\Socket\Connector($loop, ['timeout' => 5, 'tls' => ['cafile' => \_PhpScoper88fe6e0ad041\Composer\CaBundle\CaBundle::getBundledCaBundlePath()], 'dns' => '1.1.1.1']));
        /** @var array{url: string, version: string} $latestInfo */
        $latestInfo = \_PhpScoper88fe6e0ad041\Nette\Utils\Json::decode((string) \_PhpScoper88fe6e0ad041\Clue\React\Block\await($client->get('https://fixer-download-api.phpstan.com/latest'), $loop, 5)->getBody(), \_PhpScoper88fe6e0ad041\Nette\Utils\Json::FORCE_ARRAY);
        if ($currentVersion !== null && $latestInfo['version'] === $currentVersion) {
            $this->writeInfoFile($infoPath, $latestInfo['version']);
            $output->writeln('<fg=green>You\'re running the latest PHPStan Pro!</>');
            return;
        }
        $output->writeln('<fg=green>Downloading the latest PHPStan Pro...</>');
        $pharPathResource = \fopen($pharPath, 'w');
        if ($pharPathResource === \false) {
            throw new \PHPStan\ShouldNotHappenException(\sprintf('Could not open file %s for writing.', $pharPath));
        }
        $progressBar = new \_PhpScoper88fe6e0ad041\Symfony\Component\Console\Helper\ProgressBar($output);
        $client->requestStreaming('GET', $latestInfo['url'])->done(static function (\_PhpScoper88fe6e0ad041\Psr\Http\Message\ResponseInterface $response) use($progressBar, $pharPathResource) : void {
            $body = $response->getBody();
            if (!$body instanceof \_PhpScoper88fe6e0ad041\React\Stream\ReadableStreamInterface) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            $totalSize = (int) $response->getHeaderLine('Content-Length');
            $progressBar->setFormat('file_download');
            $progressBar->setMessage(\sprintf('%.2f MB', $totalSize / 1000000), 'fileSize');
            $progressBar->start($totalSize);
            $bytes = 0;
            $body->on('data', static function ($chunk) use($pharPathResource, $progressBar, &$bytes) : void {
                $bytes += \strlen($chunk);
                \fwrite($pharPathResource, $chunk);
                $progressBar->setProgress($bytes);
            });
        }, static function (\Throwable $e) use($output) : void {
            $output->writeln(\sprintf('<fg=red>Could not download the PHPStan Pro executable:</> %s', $e->getMessage()));
        });
        $loop->run();
        \fclose($pharPathResource);
        $progressBar->finish();
        $output->writeln('');
        $output->writeln('');
        $this->writeInfoFile($infoPath, $latestInfo['version']);
    }
    private function writeInfoFile(string $infoPath, string $version) : void
    {
        \PHPStan\File\FileWriter::write($infoPath, \_PhpScoper88fe6e0ad041\Nette\Utils\Json::encode(['version' => $version, 'date' => (new \DateTimeImmutable('', new \DateTimeZone('UTC')))->format(\DateTime::ATOM)]));
    }
    /**
     * @param LoopInterface $loop
     * @param callable(FileMonitorResult): void $hasChangesCallback
     */
    private function monitorFileChanges(\_PhpScoper88fe6e0ad041\React\EventLoop\LoopInterface $loop, callable $hasChangesCallback) : void
    {
        $callback = function () use(&$callback, $loop, $hasChangesCallback) : void {
            $changes = $this->fileMonitor->getChanges();
            if ($changes->hasAnyChanges()) {
                $hasChangesCallback($changes);
            }
            $loop->addTimer(1, $callback);
        };
        $loop->addTimer(1, $callback);
    }
    private function reanalyseWithTmpFile(\_PhpScoper88fe6e0ad041\React\EventLoop\LoopInterface $loop, \PHPStan\Command\InceptionResult $inceptionResult, string $mainScript, \PHPStan\Process\Runnable\RunnableQueue $runnableQueue, ?string $projectConfigFile, string $tmpFile, string $insteadOfFile, string $fixerSuggestionId, \_PhpScoper88fe6e0ad041\Symfony\Component\Console\Input\InputInterface $input) : \_PhpScoper88fe6e0ad041\React\Promise\PromiseInterface
    {
        $resultCacheManager = $this->resultCacheManagerFactory->create([$insteadOfFile => $tmpFile]);
        [$inceptionFiles] = $inceptionResult->getFiles();
        $resultCache = $resultCacheManager->restore($inceptionFiles, \false, \false, $inceptionResult->getProjectConfigArray(), $inceptionResult->getErrorOutput());
        $schedule = $this->scheduler->scheduleWork($this->cpuCoreCounter->getNumberOfCpuCores(), $resultCache->getFilesToAnalyse());
        $process = new \PHPStan\Process\ProcessPromise($loop, $fixerSuggestionId, \PHPStan\Process\ProcessHelper::getWorkerCommand($mainScript, 'fixer:worker', $projectConfigFile, ['--tmp-file', \escapeshellarg($tmpFile), '--instead-of', \escapeshellarg($insteadOfFile), '--save-result-cache', \escapeshellarg($fixerSuggestionId), '--allow-parallel'], $input));
        return $runnableQueue->queue($process, $schedule->getNumberOfProcesses());
    }
    private function reanalyseAfterFileChanges(\_PhpScoper88fe6e0ad041\React\EventLoop\LoopInterface $loop, \PHPStan\Command\InceptionResult $inceptionResult, string $mainScript, ?string $projectConfigFile, ?string $fixerSuggestionId, \_PhpScoper88fe6e0ad041\Symfony\Component\Console\Input\InputInterface $input) : \_PhpScoper88fe6e0ad041\React\Promise\PromiseInterface
    {
        $ignoredErrorHelperResult = $this->ignoredErrorHelper->initialize();
        if (\count($ignoredErrorHelperResult->getErrors()) > 0) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        $projectConfigArray = $inceptionResult->getProjectConfigArray();
        $resultCacheManager = $this->resultCacheManagerFactory->create([]);
        [$inceptionFiles, $isOnlyFiles] = $inceptionResult->getFiles();
        $resultCache = $resultCacheManager->restore($inceptionFiles, \false, \false, $projectConfigArray, $inceptionResult->getErrorOutput(), $fixerSuggestionId);
        if (\count($resultCache->getFilesToAnalyse()) === 0) {
            $result = $resultCacheManager->process(new \PHPStan\Analyser\AnalyserResult([], [], [], [], \false), $resultCache, $inceptionResult->getErrorOutput(), \false, $projectConfigArray, \true)->getAnalyserResult();
            $intermediateErrors = $ignoredErrorHelperResult->process($result->getErrors(), $isOnlyFiles, $inceptionFiles, \count($result->getInternalErrors()) > 0 || $result->hasReachedInternalErrorsCountLimit());
            $finalFileSpecificErrors = [];
            $finalNotFileSpecificErrors = [];
            foreach ($intermediateErrors as $intermediateError) {
                if (\is_string($intermediateError)) {
                    $finalNotFileSpecificErrors[] = $intermediateError;
                    continue;
                }
                $finalFileSpecificErrors[] = $intermediateError;
            }
            return \_PhpScoper88fe6e0ad041\React\Promise\resolve(['fileSpecificErrors' => $finalFileSpecificErrors, 'notFileSpecificErrors' => $finalNotFileSpecificErrors]);
        }
        $options = ['--save-result-cache', '--allow-parallel'];
        if ($fixerSuggestionId !== null) {
            $options[] = '--restore-result-cache';
            $options[] = $fixerSuggestionId;
        }
        $process = new \PHPStan\Process\ProcessPromise($loop, 'changedFileAnalysis', \PHPStan\Process\ProcessHelper::getWorkerCommand($mainScript, 'fixer:worker', $projectConfigFile, $options, $input));
        $this->processInProgress = $process->run();
        return $this->processInProgress->then(static function (string $output) : array {
            return \_PhpScoper88fe6e0ad041\Nette\Utils\Json::decode($output, \_PhpScoper88fe6e0ad041\Nette\Utils\Json::FORCE_ARRAY);
        });
    }
    private function getPhpstanVersion() : string
    {
        try {
            return \_PhpScoper88fe6e0ad041\Jean85\PrettyVersions::getVersion('phpstan/phpstan')->getPrettyVersion();
        } catch (\OutOfBoundsException $e) {
            return 'Version unknown';
        }
    }
    private function isDockerRunning() : bool
    {
        if (!\is_file('/proc/1/cgroup')) {
            return \false;
        }
        try {
            $contents = \PHPStan\File\FileReader::read('/proc/1/cgroup');
            return \strpos($contents, 'docker') !== \false;
        } catch (\PHPStan\File\CouldNotReadFileException $e) {
            return \false;
        }
    }
}