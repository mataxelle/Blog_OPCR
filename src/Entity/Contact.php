<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre prénom")
     * @Assert\Length(min=2)
     */
    public $firstname;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre prénom")
     * @Assert\Length(min=2)
     */
    public $lastname;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre prénom")
     */
    public $email;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre prénom")
     */
    public $label;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre prénom")
     */
    public $message;
    
    public $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

}