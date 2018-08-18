<?php
declare(strict_types=1);

namespace ShootDemo\Application;

use ShootDemo\Domain\TwitterAccount;

interface SocialMediaAccountRepositoryInterface
{
    public function fetchTwitterAccount(): TwitterAccount;
}
