<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PromoRepository;
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
    private int $id;

    #[ORM\Column(type: 'string', length: 63)]
    #[Assert\Length(max: 63)]
    #[Assert\NotBlank]
    private string $name;

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotBlank]
    private \DateTime $start;

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotBlank]
    private \DateTime $end;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $helloAssoFormLink;

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotBlank]
    private \DateTime $registeringStart;

    #[ORM\Column(type: 'date', nullable: false)]
    #[Assert\NotBlank]
    private \DateTime $registeringEnd;

    public function __toString()
    {
        return (string) $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    public function setEnd(\DateTime $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getHelloAssoFormLink(): ?string
    {
        return $this->helloAssoFormLink;
    }

    public function setHelloAssoFormLink(?string $helloAssoFormLink): self
    {
        $this->helloAssoFormLink = $helloAssoFormLink;

        return $this;
    }

    public function isRegisteringOpen(): bool
    {
        $now = new \DateTime();

        return $this->getRegisteringStart() <= $now && $this->getRegisteringEnd() >= $now;
    }

    public function getRegisteringStart(): \DateTime
    {
        return $this->registeringStart;
    }

    public function setRegisteringStart(\DateTime $registeringStart): self
    {
        $this->registeringStart = $registeringStart;

        return $this;
    }

    public function getRegisteringEnd(): \DateTime
    {
        return $this->registeringEnd;
    }

    public function setRegisteringEnd(\DateTime $registeringEnd): self
    {
        $this->registeringEnd = $registeringEnd;

        return $this;
    }
}
