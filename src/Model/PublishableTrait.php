<?php

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

trait PublishableTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $publishedAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $expiresAt;

    public function isPublished()
    {
        $now = new \DateTime();

        return (
            ($this->publishedAt != null && $this->publishedAt <= $now) &&
            ($this->expiresAt == null || ($this->expiresAt > $now))
        );
    }

    public function setPublished($bool)
    {
        if($bool) {
            $this->setPublishedAt(new \DateTime());
            $this->setExpiresAt(null);
        } else {
            $this->setExpiresAt(new \DateTime());
        }

        return $this;
    }

    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTime $publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
