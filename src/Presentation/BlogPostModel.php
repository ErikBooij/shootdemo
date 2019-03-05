<?php
declare(strict_types=1);

namespace ShootDemo\Presentation;

use Shoot\Shoot\HasPresenterInterface;
use Shoot\Shoot\PresentationModel;

class BlogPostModel extends PresentationModel implements HasPresenterInterface
{
    /** @var string[] */
    protected $post_content = '';

    /** @var bool */
    protected $post_exists = false;

    /** @var string */
    protected $post_title = '';

    /**
     * @return string
     */
    public function getPresenterName(): string
    {
        return BlogPostPresenter::class;
    }
}
