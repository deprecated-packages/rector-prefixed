<?php

declare (strict_types=1);
namespace RectorPrefix20210504\App;

use RectorPrefix20210504\App\BotCommentParser\BotCommentParser;
use RectorPrefix20210504\App\BotCommentParser\BotCommentParserException;
use RectorPrefix20210504\App\Playground\PlaygroundClient;
use RectorPrefix20210504\App\Playground\PlaygroundExample;
use AppendIterator;
use DateTimeImmutable;
use RectorPrefix20210504\Github\Client;
use RectorPrefix20210504\Github\HttpClient\Builder;
use RectorPrefix20210504\GuzzleHttp\Promise\Utils;
use Iterator;
use RectorPrefix20210504\League\CommonMark\DocParser;
use RectorPrefix20210504\League\CommonMark\Environment;
use RectorPrefix20210504\League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use RectorPrefix20210504\SebastianBergmann\Diff\Differ;
use RectorPrefix20210504\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
require_once __DIR__ . '/vendor/autoload.php';
$token = $_SERVER['GITHUB_PAT'];
$phpstanSrcCommit = $_SERVER['PHPSTAN_SRC_COMMIT'];
$rateLimitPlugin = new \RectorPrefix20210504\App\RateLimitPlugin();
$gitHubRequestCounter = new \RectorPrefix20210504\App\RequestCounterPlugin();
$httpBuilder = new \RectorPrefix20210504\Github\HttpClient\Builder();
$httpBuilder->addPlugin($rateLimitPlugin);
$httpBuilder->addPlugin($gitHubRequestCounter);
$client = new \RectorPrefix20210504\Github\Client($httpBuilder);
$client->authenticate($token, \RectorPrefix20210504\Github\Client::AUTH_ACCESS_TOKEN);
$rateLimitPlugin->setClient($client);
$playgroundClient = new \RectorPrefix20210504\App\Playground\PlaygroundClient(new \RectorPrefix20210504\GuzzleHttp\Client());
$markdownEnvironment = \RectorPrefix20210504\League\CommonMark\Environment::createCommonMarkEnvironment();
$markdownEnvironment->addExtension(new \RectorPrefix20210504\League\CommonMark\Extension\GithubFlavoredMarkdownExtension());
$botCommentParser = new \RectorPrefix20210504\App\BotCommentParser\BotCommentParser(new \RectorPrefix20210504\League\CommonMark\DocParser($markdownEnvironment));
/**
 * @param string $label
 * @return Iterator<int, Issue>
 */
function getIssues(string $label) : \Iterator
{
    /** @var Client */
    global $client;
    $page = 1;
    /** @var \Github\Api\Issue $api */
    $api = $client->api('issue');
    while (\true) {
        $newIssues = $api->all('phpstan', 'phpstan', ['state' => 'open', 'labels' => $label, 'page' => $page, 'per_page' => 100, 'sort' => 'created', 'direction' => 'desc']);
        if (\count($newIssues) === 0) {
            break;
        }
        yield from \array_map(function (array $issue) : Issue {
            return new \RectorPrefix20210504\App\Issue(
                $issue['number'],
                $issue['user']['login'],
                $issue['body'],
                \DateTimeImmutable::createFromFormat(\DateTimeImmutable::ATOM, $issue['updated_at']),
                // @phpstan-ignore-line
                getComments($issue['number']),
                searchBody($issue['body'], $issue['user']['login'])
            );
        }, $newIssues);
        $page++;
    }
}
/**
 * @param int $issueNumber
 * @return Comment[]
 */
function getComments(int $issueNumber) : iterable
{
    /** @var Client */
    global $client;
    $page = 1;
    /** @var BotCommentParser */
    global $botCommentParser;
    /** @var \Github\Api\Issue $api */
    $api = $client->api('issue');
    while (\true) {
        $newComments = $api->comments()->all('phpstan', 'phpstan', $issueNumber, ['page' => $page, 'per_page' => 100]);
        if (\count($newComments) === 0) {
            break;
        }
        yield from \array_map(function (array $comment) use($botCommentParser) : Comment {
            $examples = searchBody($comment['body'], $comment['user']['login']);
            if ($comment['user']['login'] === 'phpstan-bot') {
                $parserResult = $botCommentParser->parse($comment['body']);
                if (\count($examples) !== 1 || $examples[0]->getHash() !== $parserResult->getHash()) {
                    throw new \RectorPrefix20210504\App\BotCommentParser\BotCommentParserException();
                }
                return new \RectorPrefix20210504\App\BotComment($comment['body'], $examples[0], $parserResult->getDiff());
            }
            return new \RectorPrefix20210504\App\Comment($comment['user']['login'], $comment['body'], $examples);
        }, $newComments);
        $page++;
    }
}
/**
 * @param string $text
 * @param string $author
 * @return PlaygroundExample[]
 */
function searchBody(string $text, string $author) : array
{
    /** @var PlaygroundClient */
    global $playgroundClient;
    $matches = \RectorPrefix20210504\Nette\Utils\Strings::matchAll($text, '/https:\\/\\/phpstan\\.org\\/r\\/([0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12})/i');
    $examples = [];
    foreach ($matches as [$url, $hash]) {
        $examples[] = new \RectorPrefix20210504\App\Playground\PlaygroundExample($url, $hash, $author, $playgroundClient->getResultPromise($hash, $author));
    }
    return $examples;
}
$postGenerator = new \RectorPrefix20210504\App\PostGenerator(new \RectorPrefix20210504\SebastianBergmann\Diff\Differ(new \RectorPrefix20210504\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder('')), $phpstanSrcCommit);
$promiseResolver = new \RectorPrefix20210504\App\PromiseResolver();
$issuesIterator = new \AppendIterator();
$issuesIterator->append(getIssues('bug'));
$issuesIterator->append(getIssues('feature-request'));
foreach ($issuesIterator as $issue) {
    $deduplicatedExamples = [];
    foreach ($issue->getPlaygroundExamples() as $example) {
        $deduplicatedExamples[$example->getHash()] = $example;
    }
    $botComments = [];
    foreach ($issue->getComments() as $comment) {
        if ($comment instanceof \RectorPrefix20210504\App\BotComment) {
            $botComments[] = $comment;
            continue;
        }
        foreach ($comment->getPlaygroundExamples() as $example2) {
            if (isset($deduplicatedExamples[$example2->getHash()])) {
                $deduplicatedExamples[$example2->getHash()]->addUser($comment->getAuthor());
                continue;
            }
            $deduplicatedExamples[$example2->getHash()] = $example2;
        }
    }
    $issueResultsPromises = [];
    foreach ($deduplicatedExamples as $example) {
        $issueResultsPromises[] = $example->getResultPromise();
    }
    $promise = \RectorPrefix20210504\GuzzleHttp\Promise\Utils::all($issueResultsPromises)->then(function (array $results) use($postGenerator, $client, $botComments, $issue) : void {
        foreach ($results as $result) {
            $text = $postGenerator->createText($result, $botComments);
            if ($text === null) {
                continue;
            }
            /** @var \Github\Api\Issue $issueApi */
            $issueApi = $client->api('issue');
            echo \sprintf("Posting comment to issue https://github.com/phpstan/phpstan/issues/%d\n", $issue->getNumber());
            $issueApi->comments()->create('phpstan', 'phpstan', $issue->getNumber(), ['body' => $text]);
        }
    }, function (\Throwable $e) {
        echo \sprintf("%s: %s\n", \get_class($e), $e->getMessage());
    });
    $promiseResolver->push($promise, \count($issueResultsPromises));
}
$promiseResolver->flush();
echo \sprintf("Total playground requests: %d\n", $promiseResolver->getTotalCount());
echo \sprintf("Total GitHub requests: %d\n", $gitHubRequestCounter->getTotalCount());
