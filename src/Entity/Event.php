<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Behavior;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'event')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt')]
class Event
{
    use BlameableEntity;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 63)]
    #[Assert\Length(max: 63)]
    #[Assert\NotBlank]
    private $name;

    #[Behavior\Slug(fields: ['name'])]
    #[ORM\Column(type: 'string', length: 63, unique: true)]
    private $slug;

    #[ORM\Column(type: 'datetime', nullable: false)]
    #[Assert\NotBlank]
    private $start;

    #[ORM\Column(type: 'datetime', nullable: false)]
    #[Assert\NotBlank]
    private $end;

    #[ORM\Column(type: 'string', length: 127)]
    #[Assert\Length(max: 127)]
    #[Assert\NotBlank]
    private $metaDescription;

    #[ORM\Column(type: 'text', nullable: true)]
    private $content;

    #[ORM\OneToMany(targetEntity: EventHasPicture::class, mappedBy: 'event', orphanRemoval: true, cascade: ['persist'])]
    #[ORM\OrderBy(['position' => 'ASC'])]
    #[Assert\Valid]
    private $eventHasPictures;

    public function __construct()
    {
        $this->eventHasPictures = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getEventHasPictures()
    {
        return $this->eventHasPictures;
    }

    public function setEventHasPictures($eventHasPictures)
    {
        $this->eventHasPictures = $eventHasPictures;

        return $this;
    }

    public function addEventHasPicture(EventHasPicture $eventHasPicture)
    {
        if (!$this->getPictures()->contains($eventHasPicture->getMedia())) {
            $eventHasPicture->setModel($this);
            $eventHasPicture->setPosition($this->getEventHasPictures()->count() + 1);
            $this->getEventHasPictures()->add($eventHasPicture);
        }

        return $this;
    }

    public function removeEventHasPicture(EventHasPicture $eventHasPicture)
    {
        $this->getEventHasPictures()->removeElement($eventHasPicture);

        return $this;
    }

    public function getPictures()
    {
        return $this->getEventHasPictures()->map(static function (EventHasPicture $eventHasPicture) {
            return $eventHasPicture->getMedia();
        });
    }
}
