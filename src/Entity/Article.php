<?php

declare(strict_types=1);

namespace App\Entity;

use App\Config\ArticleTag;
use App\Model\PublishableTrait;
use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'article', indexes: [new ORM\Index(columns: ['published_at']), new ORM\Index(columns: ['deleted_at']), new ORM\Index(columns: ['expires_at', 'published_at', 'deleted_at'])])]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt')]
class Article
{
    use BlameableEntity;
    use PublishableTrait;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    private string $imageLink;

    #[ORM\Column(type: 'string', length: 63)]
    #[Assert\Length(max: 63)]
    #[Assert\NotBlank]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $content;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $start = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $end = null;

    #[ORM\Column(length: 127, nullable: true)]
    #[Assert\Length(max: 127)]
    private ?string $location = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $startTime = null;

    #[ORM\Column(length: 63)]
    #[Assert\Length(max: 63)]
    #[Assert\NotBlank]
    private string $buttonLabel;

    #[ORM\Column(length: 255)]
    #[Assert\Url]
    #[Assert\NotBlank]
    private string $buttonLink;

    #[ORM\Column(nullable: true, enumType: ArticleTag::class)]
    private ?ArticleTag $tag = null;

    public function __toString()
    {
        return (string) $this->title;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getImageLink(): string
    {
        return $this->imageLink;
    }

    public function setImageLink(string $imageLink): self
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStart(): ?\DateTimeImmutable
    {
        return $this->start;
    }

    public function setStart(?\DateTimeImmutable $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeImmutable
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeImmutable $end): static
    {
        $this->end = $end;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getStartTime(): ?\DateTimeImmutable
    {
        return $this->startTime;
    }

    public function setStartTime(?\DateTimeImmutable $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getButtonLabel(): string
    {
        return $this->buttonLabel;
    }

    public function setButtonLabel(string $buttonLabel): static
    {
        $this->buttonLabel = $buttonLabel;

        return $this;
    }

    public function getButtonLink(): string
    {
        return $this->buttonLink;
    }

    public function setButtonLink(string $buttonLink): static
    {
        $this->buttonLink = $buttonLink;

        return $this;
    }

    public function getTag(): ?ArticleTag
    {
        return $this->tag;
    }

    public function setTag(?ArticleTag $tag): static
    {
        $this->tag = $tag;

        return $this;
    }
}
