#!/usr/bin/env php
<?php 
declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use _PhpScoperabd03f0baf05\Httpful\Request;
use _PhpScoperabd03f0baf05\Symfony\Component\Console\Input\InputArgument;
use _PhpScoperabd03f0baf05\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperabd03f0baf05\Symfony\Component\Console\Output\OutputInterface;
(function () {
    require_once __DIR__ . '/../vendor/autoload.php';
    $command = new class extends \_PhpScoperabd03f0baf05\Symfony\Component\Console\Command\Command
    {
        protected function configure()
        {
            $this->setName('run');
            $this->addArgument('fromCommit', \_PhpScoperabd03f0baf05\Symfony\Component\Console\Input\InputArgument::REQUIRED);
            $this->addArgument('toCommit', \_PhpScoperabd03f0baf05\Symfony\Component\Console\Input\InputArgument::REQUIRED);
        }
        protected function execute(\_PhpScoperabd03f0baf05\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoperabd03f0baf05\Symfony\Component\Console\Output\OutputInterface $output)
        {
            $commitLines = $this->exec(['git', 'log', \sprintf('%s..%s', $input->getArgument('fromCommit'), $input->getArgument('toCommit')), '--reverse', '--pretty=%H %s']);
            $commits = \array_map(function (string $line) : array {
                [$hash, $message] = \explode(' ', $line, 2);
                return ['hash' => $hash, 'message' => $message];
            }, \explode("\n", $commitLines));
            $i = 0;
            foreach ($commits as $commit) {
                $searchPullRequestsResponse = \_PhpScoperabd03f0baf05\Httpful\Request::get(\sprintf('https://api.github.com/search/issues?q=repo:phpstan/phpstan-src+%s', $commit['hash']))->sendsAndExpectsType('application/json')->basicAuth('ondrejmirtes', \getenv('GITHUB_TOKEN'))->send();
                if ($searchPullRequestsResponse->code !== 200) {
                    $output->writeln(\var_export($searchPullRequestsResponse->body, \true));
                    throw new \InvalidArgumentException((string) $searchPullRequestsResponse->code);
                }
                $searchPullRequestsResponse = $searchPullRequestsResponse->body;
                $searchIssuesResponse = \_PhpScoperabd03f0baf05\Httpful\Request::get(\sprintf('https://api.github.com/search/issues?q=repo:phpstan/phpstan+%s', $commit['hash']))->sendsAndExpectsType('application/json')->basicAuth('ondrejmirtes', \getenv('GITHUB_TOKEN'))->send();
                if ($searchIssuesResponse->code !== 200) {
                    $output->writeln(\var_export($searchIssuesResponse->body, \true));
                    throw new \InvalidArgumentException((string) $searchIssuesResponse->code);
                }
                $searchIssuesResponse = $searchIssuesResponse->body;
                $items = \array_merge($searchPullRequestsResponse->items, $searchIssuesResponse->items);
                $parenthesis = 'https://github.com/phpstan/phpstan-src/commit/' . $commit['hash'];
                $thanks = null;
                $issuesToReference = [];
                foreach ($items as $responseItem) {
                    if (isset($responseItem->pull_request)) {
                        $parenthesis = \sprintf('[#%d](%s)', $responseItem->number, 'https://github.com/phpstan/phpstan-src/pull/' . $responseItem->number);
                        $thanks = $responseItem->user->login;
                    } else {
                        $issuesToReference[] = \sprintf('#%d', $responseItem->number);
                    }
                }
                $output->writeln(\sprintf('* %s (%s)%s%s', $commit['message'], $parenthesis, \count($issuesToReference) > 0 ? ', ' . \implode(', ', $issuesToReference) : '', $thanks !== null ? \sprintf(', thanks @%s!', $thanks) : ''));
                if ($i > 0 && $i % 8 === 0) {
                    \sleep(60);
                }
                $i++;
            }
            return 0;
        }
        /**
         * @param string[] $commandParts
         * @return string
         */
        private function exec(array $commandParts) : string
        {
            $command = \implode(' ', \array_map(function (string $part) : string {
                return \escapeshellarg($part);
            }, $commandParts));
            \exec($command, $outputLines, $statusCode);
            $output = \implode("\n", $outputLines);
            if ($statusCode !== 0) {
                throw new \InvalidArgumentException(\sprintf('Command %s failed: %s', $command, $output));
            }
            return $output;
        }
    };
    $application = new \_PhpScoperabd03f0baf05\Symfony\Component\Console\Application();
    $application->add($command);
    $application->setDefaultCommand('run', \true);
    $application->run();
})();
