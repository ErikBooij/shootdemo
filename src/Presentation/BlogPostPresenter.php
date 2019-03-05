<?php
declare(strict_types=1);

namespace ShootDemo\Presentation;

use Psr\Http\Message\ServerRequestInterface;
use Shoot\Shoot\PresentationModel;
use Shoot\Shoot\PresenterInterface;
use ShootDemo\Application\BlogPostRepositoryInterface;
use ShootDemo\Application\UnableToFetchBlogPostException;

class BlogPostPresenter implements PresenterInterface
{
    /** @var BlogPostRepositoryInterface */
    private $blogPostRepository;

    /**
     * @param BlogPostRepositoryInterface $socialMediaAccountRepository
     */
    public function __construct(BlogPostRepositoryInterface $socialMediaAccountRepository)
    {
        $this->blogPostRepository = $socialMediaAccountRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param PresentationModel      $presentationModel
     *
     * @return PresentationModel
     */
    public function present(ServerRequestInterface $request, PresentationModel $presentationModel): PresentationModel
    {
        $postId = (int)($request->getQueryParams()['postId'] ?? -1);

        try {
            $blogPost = $this->blogPostRepository->fetchBlogPost($postId);
        } catch (UnableToFetchBlogPostException $ex) {
            // Unable to load blog post return presentation model, explicitly setting post_exists to false
            return $presentationModel->withVariables([
                'post_exists' => false,
            ]);
        }

        $variables = [
            'post_content' => $blogPost->content(),
            'post_exists'  => true,
            'post_title'   => $blogPost->title(),
        ];

        return $presentationModel->withVariables($variables);
    }
}
