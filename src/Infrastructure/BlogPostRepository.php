<?php
declare(strict_types=1);

namespace ShootDemo\Infrastructure;

use ShootDemo\Application\BlogPostRepositoryInterface;
use ShootDemo\Application\UnableToFetchBlogPostException;
use ShootDemo\Domain\BlogPost;

class BlogPostRepository implements BlogPostRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function fetchBlogPost(int $postId): BlogPost
    {
        $blogContentFile = __DIR__ . "/../../resources/blog-{$postId}.json";

        if (!file_exists($blogContentFile) || !is_readable($blogContentFile)) {
            throw UnableToFetchBlogPostException::forPostId($postId);
        }

        $blogContent = file_get_contents($blogContentFile);
        $parsedBlogContent = json_decode($blogContent, true);

        if (!is_array($parsedBlogContent) || json_last_error() !== JSON_ERROR_NONE) {
            throw UnableToFetchBlogPostException::forPostId($postId);
        }

        return new BlogPost(
            $parsedBlogContent['title'],
            $parsedBlogContent['content']
        );
    }
}
