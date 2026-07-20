<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TestimonyRepository;
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
}
