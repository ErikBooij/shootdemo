<?php
declare(strict_types=1);

namespace ShootDemo\Domain;

class BlogPost
{
    /** @var string */
    private $title;

    /** @var array */
    private $content;

    /**
     * @param string $title
     * @param string[] $content
     */
    public function __construct(string $title, array $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string[]
     */
    public function content(): array
    {
        return $this->content;
    }
}
