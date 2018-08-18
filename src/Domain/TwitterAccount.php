<?php
declare(strict_types=1);

namespace ShootDemo\Domain;

class TwitterAccount
{
    /** @var string */
    private $handle;

    /** @var string */
    private $name;

    /**
     * @param string $name
     * @param string $handle
     */
    public function __construct(string $name, string $handle)
    {
        $this->name = $name;
        $this->handle = $handle;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function handle(): string
    {
        return $this->handle;
    }
}
