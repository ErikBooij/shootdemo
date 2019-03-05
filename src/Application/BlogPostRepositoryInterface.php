<?php
declare(strict_types=1);

namespace ShootDemo\Application;

use ShootDemo\Domain\BlogPost;

interface BlogPostRepositoryInterface
{
    /**
     * @param int $postId
     *
     * @return BlogPost
     *
     * @throws UnableToFetchBlogPostException
     */
    public function fetchBlogPost(int $postId): BlogPost;
}
