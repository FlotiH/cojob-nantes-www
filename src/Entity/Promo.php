<?php

namespace App\Entity;

use App\Repository\PromoRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PromoRepository::class)]
#[ORM\Table(name: 'promo')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt')]
class Promo
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

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotBlank]
    private $start;

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotBlank]
    private $end;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private $helloAssoFormLink;

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotBlank]
    private $registeringStart;

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotBlank]
    private $registeringEnd;

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

    public function getHelloAssoFormLink()
    {
        return $this->helloAssoFormLink;
    }

    public function setHelloAssoFormLink($helloAssoFormLink)
    {
        $this->helloAssoFormLink = $helloAssoFormLink;

        return $this;
    }

    public function isRegisteringOpen()
    {
        $now = new DateTime();

        return $this->getRegisteringStart() <= $now && $this->getRegisteringEnd() >= $now;
    }

    public function getRegisteringStart()
    {
        return $this->registeringStart;
    }

    public function setRegisteringStart($registeringStart)
    {
        $this->registeringStart = $registeringStart;

        return $this;
    }

    public function getRegisteringEnd()
    {
        return $this->registeringEnd;
    }

    public function setRegisteringEnd($registeringEnd)
    {
        $this->registeringEnd = $registeringEnd;

        return $this;
    }
}
