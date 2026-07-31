<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'contact')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt')]
class Contact
{
    use BlameableEntity;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'last_name', type: 'string', length: 63)]
    #[Assert\NotBlank(message: 'contact.form.last_name.not_blank')]
    #[Assert\Length(max: 63)]
    protected string $last_name;

    #[ORM\Column(name: 'first_name', type: 'string', length: 63)]
    #[Assert\NotBlank(message: 'contact.form.first_name.not_blank')]
    #[Assert\Length(max: 63)]
    protected string $first_name;

    #[ORM\Column(name: 'email', type: 'string', length: 127)]
    #[Assert\NotBlank(message: 'contact.form.email.not_blank')]
    #[Assert\Length(max: 127)]
    #[Assert\Email(message: 'contact.form.email.check_mx', mode: 'strict')]
    protected string $email;

    #[ORM\Column(name: 'message', type: 'text')]
    #[Assert\NotBlank]
    protected string $message;

    #[ORM\Column(type: 'string', nullable: true, length: 15)]
    private ?string $telephone = null;

    // honeypot
    protected ?string $name = null;

    public function __toString()
    {
        return $this->getFirstname().' '.$this->getLastname();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
