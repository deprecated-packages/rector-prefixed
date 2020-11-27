<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel;

use _PhpScoperbd5d0c5f7638\Symfony\Component\BrowserKit\AbstractBrowser;
use _PhpScoperbd5d0c5f7638\Symfony\Component\BrowserKit\CookieJar;
use _PhpScoperbd5d0c5f7638\Symfony\Component\BrowserKit\History;
use _PhpScoperbd5d0c5f7638\Symfony\Component\BrowserKit\Request as DomRequest;
use _PhpScoperbd5d0c5f7638\Symfony\Component\BrowserKit\Response as DomResponse;
use _PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\File\UploadedFile;
use _PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\Request;
use _PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\Response;
/**
 * Client simulates a browser and makes requests to an HttpKernel instance.
 *
 * @method Request  getRequest()  A Request instance
 * @method Response getResponse() A Response instance
 *
 * @deprecated since Symfony 4.3, use HttpKernelBrowser instead.
 */
class Client extends \_PhpScoperbd5d0c5f7638\Symfony\Component\BrowserKit\AbstractBrowser
{
    protected $kernel;
    private $catchExceptions = \true;
    /**
     * @param array $server The server parameters (equivalent of $_SERVER)
     */
    public function __construct(\_PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\HttpKernelInterface $kernel, array $server = [], \_PhpScoperbd5d0c5f7638\Symfony\Component\BrowserKit\History $history = null, \_PhpScoperbd5d0c5f7638\Symfony\Component\BrowserKit\CookieJar $cookieJar = null)
    {
        // These class properties must be set before calling the parent constructor, as it may depend on it.
        $this->kernel = $kernel;
        $this->followRedirects = \false;
        parent::__construct($server, $history, $cookieJar);
    }
    /**
     * Sets whether to catch exceptions when the kernel is handling a request.
     *
     * @param bool $catchExceptions Whether to catch exceptions
     */
    public function catchExceptions($catchExceptions)
    {
        $this->catchExceptions = $catchExceptions;
    }
    /**
     * Makes a request.
     *
     * @return Response A Response instance
     */
    protected function doRequest($request)
    {
        $response = $this->kernel->handle($request, \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST, $this->catchExceptions);
        if ($this->kernel instanceof \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpKernel\TerminableInterface) {
            $this->kernel->terminate($request, $response);
        }
        return $response;
    }
    /**
     * Returns the script to execute when the request must be insulated.
     *
     * @return string
     */
    protected function getScript($request)
    {
        $kernel = \var_export(\serialize($this->kernel), \true);
        $request = \var_export(\serialize($request), \true);
        $errorReporting = \error_reporting();
        $requires = '';
        foreach (\get_declared_classes() as $class) {
            if (0 === \strpos($class, 'ComposerAutoloaderInit')) {
                $r = new \ReflectionClass($class);
                $file = \dirname($r->getFileName(), 2) . '/autoload.php';
                if (\file_exists($file)) {
                    $requires .= 'require_once ' . \var_export($file, \true) . ";\n";
                }
            }
        }
        if (!$requires) {
            throw new \RuntimeException('Composer autoloader not found.');
        }
        $code = <<<EOF
<?php

error_reporting({$errorReporting});

{$requires}

\$kernel = unserialize({$kernel});
\$request = unserialize({$request});
EOF;
        return $code . $this->getHandleScript();
    }
    protected function getHandleScript()
    {
        return <<<'EOF'
$response = $kernel->handle($request);

if ($kernel instanceof Symfony\Component\HttpKernel\TerminableInterface) {
    $kernel->terminate($request, $response);
}

echo serialize($response);
EOF;
    }
    /**
     * Converts the BrowserKit request to a HttpKernel request.
     *
     * @return Request A Request instance
     */
    protected function filterRequest(\_PhpScoperbd5d0c5f7638\Symfony\Component\BrowserKit\Request $request)
    {
        $httpRequest = \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\Request::create($request->getUri(), $request->getMethod(), $request->getParameters(), $request->getCookies(), $request->getFiles(), $request->getServer(), $request->getContent());
        foreach ($this->filterFiles($httpRequest->files->all()) as $key => $value) {
            $httpRequest->files->set($key, $value);
        }
        return $httpRequest;
    }
    /**
     * Filters an array of files.
     *
     * This method created test instances of UploadedFile so that the move()
     * method can be called on those instances.
     *
     * If the size of a file is greater than the allowed size (from php.ini) then
     * an invalid UploadedFile is returned with an error set to UPLOAD_ERR_INI_SIZE.
     *
     * @see UploadedFile
     *
     * @return array An array with all uploaded files marked as already moved
     */
    protected function filterFiles(array $files)
    {
        $filtered = [];
        foreach ($files as $key => $value) {
            if (\is_array($value)) {
                $filtered[$key] = $this->filterFiles($value);
            } elseif ($value instanceof \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\File\UploadedFile) {
                if ($value->isValid() && $value->getSize() > \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\File\UploadedFile::getMaxFilesize()) {
                    $filtered[$key] = new \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\File\UploadedFile('', $value->getClientOriginalName(), $value->getClientMimeType(), \UPLOAD_ERR_INI_SIZE, \true);
                } else {
                    $filtered[$key] = new \_PhpScoperbd5d0c5f7638\Symfony\Component\HttpFoundation\File\UploadedFile($value->getPathname(), $value->getClientOriginalName(), $value->getClientMimeType(), $value->getError(), \true);
                }
            }
        }
        return $filtered;
    }
    /**
     * Converts the HttpKernel response to a BrowserKit response.
     *
     * @return DomResponse A DomResponse instance
     */
    protected function filterResponse($response)
    {
        // this is needed to support StreamedResponse
        \ob_start();
        $response->sendContent();
        $content = \ob_get_clean();
        return new \_PhpScoperbd5d0c5f7638\Symfony\Component\BrowserKit\Response($content, $response->getStatusCode(), $response->headers->all());
    }
}
