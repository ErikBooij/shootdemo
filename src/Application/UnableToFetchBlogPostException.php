<?php
declare(strict_types=1);

namespace ShootDemo\Application;

use RuntimeException;

class UnableToFetchBlogPostException extends RuntimeException
{
    /**
     * @inheritdoc
     */
    public static function forPostId(int $postId): self
    {
        return new static("Unable to fetch blog post with ID {$postId} from file system");
    }
}
