<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Parallel;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Clue\React\NDJson\Decoder;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Clue\React\NDJson\Encoder;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Random;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\AnalyserResult;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Error;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Dependency\ExportedNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Process\ProcessHelper;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\EventLoop\StreamSelectLoop;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Socket\ConnectionInterface;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputInterface;
use function parse_url;
class ParallelAnalyser
{
    /** @var int */
    private $internalErrorsCountLimit;
    /** @var float */
    private $processTimeout;
    /** @var ProcessPool */
    private $processPool;
    /** @var int */
    private $decoderBufferSize;
    public function __construct(int $internalErrorsCountLimit, float $processTimeout, int $decoderBufferSize)
    {
        $this->internalErrorsCountLimit = $internalErrorsCountLimit;
        $this->processTimeout = $processTimeout;
        $this->decoderBufferSize = $decoderBufferSize;
    }
    /**
     * @param Schedule $schedule
     * @param string $mainScript
     * @param \Closure(int): void|null $postFileCallback
     * @param string|null $projectConfigFile
     * @param string|null $tmpFile
     * @param string|null $insteadOfFile
     * @return AnalyserResult
     */
    public function analyse(\_PhpScoper2a4e7ab1ecbc\PHPStan\Parallel\Schedule $schedule, string $mainScript, ?\Closure $postFileCallback, ?string $projectConfigFile, ?string $tmpFile, ?string $insteadOfFile, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputInterface $input) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\AnalyserResult
    {
        $jobs = \array_reverse($schedule->getJobs());
        $loop = new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\EventLoop\StreamSelectLoop();
        $numberOfProcesses = $schedule->getNumberOfProcesses();
        $errors = [];
        $internalErrors = [];
        $server = new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Socket\TcpServer('127.0.0.1:0', $loop);
        $this->processPool = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Parallel\ProcessPool($server);
        $server->on('connection', function (\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Socket\ConnectionInterface $connection) use(&$jobs) : void {
            $decoder = new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Clue\React\NDJson\Decoder($connection, \true, 512, \defined('JSON_INVALID_UTF8_IGNORE') ? \JSON_INVALID_UTF8_IGNORE : 0, $this->decoderBufferSize);
            $encoder = new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Clue\React\NDJson\Encoder($connection, \defined('JSON_INVALID_UTF8_IGNORE') ? \JSON_INVALID_UTF8_IGNORE : 0);
            $decoder->on('data', function (array $data) use(&$jobs, $decoder, $encoder) : void {
                if ($data['action'] !== 'hello') {
                    return;
                }
                $identifier = $data['identifier'];
                $process = $this->processPool->getProcess($identifier);
                $process->bindConnection($decoder, $encoder);
                if (\count($jobs) === 0) {
                    $this->processPool->quitProcess($identifier);
                    return;
                }
                $job = \array_pop($jobs);
                $process->request(['action' => 'analyse', 'files' => $job]);
            });
        });
        /** @var string $serverAddress */
        $serverAddress = $server->getAddress();
        /** @var int $serverPort */
        $serverPort = \parse_url($serverAddress, \PHP_URL_PORT);
        $internalErrorsCount = 0;
        $reachedInternalErrorsCountLimit = \false;
        $handleError = function (\Throwable $error) use(&$internalErrors, &$internalErrorsCount, &$reachedInternalErrorsCountLimit) : void {
            $internalErrors[] = \sprintf('Internal error: ' . $error->getMessage());
            $internalErrorsCount++;
            $reachedInternalErrorsCountLimit = \true;
            $this->processPool->quitAll();
        };
        $dependencies = [];
        $exportedNodes = [];
        for ($i = 0; $i < $numberOfProcesses; $i++) {
            if (\count($jobs) === 0) {
                break;
            }
            $processIdentifier = \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Random::generate();
            $commandOptions = ['--port', (string) $serverPort, '--identifier', $processIdentifier];
            if ($tmpFile !== null && $insteadOfFile !== null) {
                $commandOptions[] = '--tmp-file';
                $commandOptions[] = \escapeshellarg($tmpFile);
                $commandOptions[] = '--instead-of';
                $commandOptions[] = \escapeshellarg($insteadOfFile);
            }
            $process = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Parallel\Process(\_PhpScoper2a4e7ab1ecbc\PHPStan\Process\ProcessHelper::getWorkerCommand($mainScript, 'worker', $projectConfigFile, $commandOptions, $input), $loop, $this->processTimeout);
            $process->start(function (array $json) use($process, &$internalErrors, &$errors, &$dependencies, &$exportedNodes, &$jobs, $postFileCallback, &$internalErrorsCount, &$reachedInternalErrorsCountLimit, $processIdentifier) : void {
                foreach ($json['errors'] as $jsonError) {
                    if (\is_string($jsonError)) {
                        $internalErrors[] = \sprintf('Internal error: %s', $jsonError);
                        continue;
                    }
                    $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Error::decode($jsonError);
                }
                /**
                 * @var string $file
                 * @var array<string> $fileDependencies
                 */
                foreach ($json['dependencies'] as $file => $fileDependencies) {
                    $dependencies[$file] = $fileDependencies;
                }
                /**
                 * @var string $file
                 * @var array<ExportedNode> $fileExportedNodes
                 */
                foreach ($json['exportedNodes'] as $file => $fileExportedNodes) {
                    if (\count($fileExportedNodes) === 0) {
                        continue;
                    }
                    $exportedNodes[$file] = \array_map(static function (array $node) : ExportedNode {
                        $class = $node['type'];
                        return $class::decode($node['data']);
                    }, $fileExportedNodes);
                }
                if ($postFileCallback !== null) {
                    $postFileCallback($json['filesCount']);
                }
                $internalErrorsCount += $json['internalErrorsCount'];
                if ($internalErrorsCount >= $this->internalErrorsCountLimit) {
                    $reachedInternalErrorsCountLimit = \true;
                    $this->processPool->quitAll();
                }
                if (\count($jobs) === 0) {
                    $this->processPool->quitProcess($processIdentifier);
                    return;
                }
                $job = \array_pop($jobs);
                $process->request(['action' => 'analyse', 'files' => $job]);
            }, $handleError, function ($exitCode, string $output) use(&$internalErrors, &$internalErrorsCount, $processIdentifier) : void {
                $this->processPool->tryQuitProcess($processIdentifier);
                if ($exitCode === 0) {
                    return;
                }
                if ($exitCode === null) {
                    return;
                }
                $internalErrors[] = \sprintf('Child process error (exit code %d): %s', $exitCode, $output);
                $internalErrorsCount++;
            });
            $this->processPool->attachProcess($processIdentifier, $process);
        }
        $loop->run();
        if (\count($jobs) > 0 && $internalErrorsCount === 0) {
            $internalErrors[] = 'Some parallel worker jobs have not finished.';
            $internalErrorsCount++;
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\AnalyserResult($errors, $internalErrors, $internalErrorsCount === 0 ? $dependencies : null, $exportedNodes, $reachedInternalErrorsCountLimit);
    }
}
