<?php
declare(strict_types=1);

use GuzzleHttp\Psr7\ServerRequest;
use League\Container\Container;
use Shoot\Shoot\Middleware\PresenterMiddleware;
use Shoot\Shoot\Pipeline;
use ShootDemo\Application\SocialMediaAccountRepository;
use ShootDemo\Domain\User;
use ShootDemo\Presentation\TwitterIconPresenter;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

include __DIR__ . '/../vendor/autoload.php';

// Set up Twig
$loader = new FilesystemLoader(['../templates']);
$twig = new Environment($loader);

// Set up a PSR-11 compliant container that Shoot uses to load presenters
$container = new Container();
$container->add(TwitterIconPresenter::class, new TwitterIconPresenter(new SocialMediaAccountRepository));

// Create Shoot's presenter middleware and add Shoot to Twig
$presenterMiddleware = new PresenterMiddleware($container);
$pipeline = new Pipeline([$presenterMiddleware]);
$twig->addExtension($pipeline);

// Fake adding the logged in user to the PSR-7 request
$request = ServerRequest::fromGlobals()->withAttribute('loggedInUser', new User('Rasmus'));

// Pass the request as context to the pipeline and pass a callback that renders a template in twig
$pipeline->withContext($request, function () use ($twig) {
    echo $twig->render('social-icons.twig');
});
