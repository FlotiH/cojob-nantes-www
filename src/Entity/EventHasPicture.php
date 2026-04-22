<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'event_has_picture', indexes: [new ORM\Index(columns: ['position'])])]
class EventHasPicture
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: 'eventHasPictures', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private $event;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Media2::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Expression("value != null and value.getProvider() == 'image'", message: 'Media must be an image')]
    #[Assert\NotNull]
    private $media;

    #[ORM\Column(type: 'integer')]
    private $position;

    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    public function setModel(Event $event)
    {
        $this->event = $event;

        return $this;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function setMedia(?Media $media)
    {
        $this->media = $media;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
}
