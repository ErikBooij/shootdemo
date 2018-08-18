<?php
declare(strict_types=1);

namespace ShootDemo\Presentation;

use Psr\Http\Message\ServerRequestInterface;
use Shoot\Shoot\PresentationModel;
use Shoot\Shoot\PresenterInterface;
use ShootDemo\Application\SocialMediaAccountRepositoryInterface;
use ShootDemo\Domain\User;

class TwitterIconPresenter implements PresenterInterface
{
    /** @var SocialMediaAccountRepositoryInterface */
    private $socialMediaAccountRepository;

    /**
     * @param SocialMediaAccountRepositoryInterface $socialMediaAccountRepository
     */
    public function __construct(SocialMediaAccountRepositoryInterface $socialMediaAccountRepository)
    {
        $this->socialMediaAccountRepository = $socialMediaAccountRepository;
    }

    /**
     * @param ServerRequestInterface $context
     * @param PresentationModel      $presentationModel
     *
     * @return PresentationModel
     */
    public function present($context, PresentationModel $presentationModel): PresentationModel
    {
        $twitterAccount = $this->socialMediaAccountRepository->fetchTwitterAccount();

        $variables = [
            'twitter_account_name' => $twitterAccount->name(),
            'twitter_handle'       => $twitterAccount->handle(),
        ];

        $user = $context->getAttribute('loggedInUser');

        if ($user instanceof User) {
            $variables['user_is_logged_in'] = true;
            $variables['user_first_name'] = $user->firstName();
        }

        return $presentationModel->withVariables($variables);
    }
}
