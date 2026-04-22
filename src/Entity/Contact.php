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
    private $id;

    #[ORM\Column(name: 'last_name', type: 'string', length: 63)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 63)]
    protected $last_name;

    #[ORM\Column(name: 'first_name', type: 'string', length: 63)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 63)]
    protected $first_name;

    #[ORM\Column(name: 'email', type: 'string', length: 127)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 127)]
    #[Assert\Email]
    protected $email;

    #[ORM\Column(name: 'message', type: 'text')]
    #[Assert\NotBlank]
    protected $message;

    #[ORM\Column(type: 'string', nullable: true, length: 15)]
    private $telephone;

    // honeypot
    protected $name;

    public function __toString()
    {
        return $this->getFirstname().' '.$this->getLastname();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
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
}
