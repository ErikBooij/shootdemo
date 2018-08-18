<?php
declare(strict_types=1);

namespace ShootDemo\Application;

use ShootDemo\Domain\TwitterAccount;

class SocialMediaAccountRepository implements SocialMediaAccountRepositoryInterface
{
    /**
     * @return TwitterAccount
     */
    public function fetchTwitterAccount(): TwitterAccount
    {
        // Demo implementation
        return new TwitterAccount('PHP.net', 'official_php');
    }
}
