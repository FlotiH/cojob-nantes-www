<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\PublishableTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
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
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    private $imageLink;

    #[ORM\Column(type: 'string', length: 63)]
    #[Assert\Length(max: 63)]
    #[Assert\NotBlank]
    private $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $content;

    public function __toString()
    {
        return (string) $this->title;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getImageLink()
    {
        return $this->imageLink;
    }

    public function setImageLink($imageLink)
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

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
}
