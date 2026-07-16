<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

trait PublishableTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $publishedAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $expiresAt;

    public function isPublished(): bool
    {
        $now = new \DateTime();

        return
            (null !== $this->publishedAt && $this->publishedAt <= $now)
            && (null === $this->expiresAt || ($this->expiresAt > $now))
        ;
    }

    public function setPublished(bool $bool): self
    {
        if ($bool) {
            $this->setPublishedAt(new \DateTime());
            $this->setExpiresAt(null);
        } else {
            $this->setExpiresAt(new \DateTime());
        }

        return $this;
    }

    public function getPublishedAt(): ?\DateTime
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTime $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getExpiresAt(): ?\DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTime $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
