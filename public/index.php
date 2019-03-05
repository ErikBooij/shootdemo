<?php
declare(strict_types=1);

use GuzzleHttp\Psr7\ServerRequest;
use Idealo\Middleware\Stack;
use League\Container\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shoot\Shoot\Http\ShootMiddleware;
use Shoot\Shoot\Installer;
use Shoot\Shoot\Middleware\PresenterMiddleware;
use Shoot\Shoot\Pipeline;
use ShootDemo\Infrastructure\BlogPostRepository;
use ShootDemo\Presentation\BlogPostPresenter;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;

include __DIR__ . '/../vendor/autoload.php';

// Set up Twig
$loader = new FilesystemLoader(['../templates']);
$twig = new Environment($loader);

// Set up a PSR-11 compliant container that Shoot uses to load presenters
$container = new Container();
$container->add(BlogPostPresenter::class, new BlogPostPresenter(new BlogPostRepository));

// Create Shoot's presenter middleware
$presenterMiddleware = new PresenterMiddleware($container);
$pipeline = new Pipeline([$presenterMiddleware]);
$installer = new Installer($pipeline);

// Add Shoot to Twig
$twig = $installer->install($twig);

// Create a ServerRequest the easy way
$request = ServerRequest::fromGlobals();

$requestHandler = new class ($twig) implements MiddlewareInterface  {
    /** @var Environment */
    private $twig;

    /**
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface|void
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new HtmlResponse($this->twig->render('layout.twig'));
    }
};

// Create the middleware stack (in this case with an anonymous class as "controller")
$middlewareStack = new Stack(
    new EmptyResponse(),
    new ShootMiddleware($pipeline),
    $requestHandler
);

// Execute the middleware stack
$response = $middlewareStack->handle($request);

// Emit the response
(new Zend\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
