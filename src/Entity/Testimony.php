<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TestimonyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TestimonyRepository::class)]
#[ORM\Table(name: 'testimony')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt')]
class Testimony
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

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    private string $subtitle;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    private string $content;

    #[ORM\Column(type: 'boolean')]
    private bool $promo = true;

    #[ORM\Column(type: 'boolean')]
    private bool $requiredDisplaying = false;

    #[ORM\Column(length: 31)]
    #[Assert\Length(max: 31)]
    #[Assert\NotBlank]
    private string $firstname;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Assert\Positive()]
    private ?int $age = null;

    #[ORM\Column(length: 31)]
    #[Assert\Length(max: 31)]
    #[Assert\NotBlank]
    private string $promoNb;

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

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isPromo(): bool
    {
        return $this->promo;
    }

    public function setPromo(bool $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function isRequiredDisplaying(): bool
    {
        return $this->requiredDisplaying;
    }

    public function setRequiredDisplaying(bool $requiredDisplaying): self
    {
        $this->requiredDisplaying = $requiredDisplaying;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPromoNb(): ?string
    {
        return $this->promoNb;
    }

    public function setPromoNb(string $promoNb): static
    {
        $this->promoNb = $promoNb;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }
}
