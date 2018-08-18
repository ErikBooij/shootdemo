<?php
declare(strict_types=1);

namespace ShootDemo\Domain;

class User
{
    /** @var string */
    private $firstName;

    /**
     * @param string $firstName
     */
    public function __construct(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function firstName(): string
    {
        return $this->firstName;
    }
}
