<?php

namespace App\Entity;

use \DateTimeInterface;

class TheRegisterCoUkSoftwareHeadlinesFeed
{
    /**
     * @var DateTimeInterface
     */
    private $date;
    /**
     * @var string
     */
    private $authorName;
    /**
     * @var string
     */
    private $authorUri;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $summary;
    /**
     * @var string
     */
    private $link;

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function getAuthorUri(): ?string
    {
        return $this->authorUri;
    }

    public function setAuthorUri(string $authorUri): self
    {
        $this->authorUri = $authorUri;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
