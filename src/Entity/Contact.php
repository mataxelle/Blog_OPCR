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
    private $firstname;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre prénom")
     * @Assert\Length(min=2)
     */
    private $lastname;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre email")
     * @Assert\Length(min=2)
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Veuillez choisir")
     * @Assert\Length(min=2)
     */
    private $label;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre message")
     * @Assert\Length(min=2)
     */
    private $message;
    
    private $createdAt;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }
    
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {

            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                switch ($key)
                {
                    case 'id':
                        $this->$method((int) $value);
                        break;
                    case 'firstname':
                    case 'lastname':
                    case 'email':
                    case 'label':
                    case 'message':
                        $this->$method((string) $value);
                        break;
                    case 'createdAt':    
                        $this->$method(new \DateTime($value));
                        break;
                }
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (is_string($id) && intval($id) > 0) {
            $this->id = intval($id);
        }
        if (is_int($id) && $id > 0) {
            $this->id = $id;
        }
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