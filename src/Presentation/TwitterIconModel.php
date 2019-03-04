<?php
declare(strict_types=1);

namespace ShootDemo\Presentation;

use Shoot\Shoot\HasPresenterInterface;
use Shoot\Shoot\PresentationModel;

class TwitterIconModel extends PresentationModel implements HasPresenterInterface
{
    /** @var string */
    protected $twitter_account_name = '';

    /** @var string */
    protected $twitter_handle = '';

    /** @var string */
    protected $user_first_name = '';

    /** @var string */
    protected $user_is_logged_in = false;

    /**
     * @return string
     */
    public function getPresenterName(): string
    {
        return TwitterIconPresenter::class;
    }
}
