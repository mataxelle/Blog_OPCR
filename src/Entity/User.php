<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class User
{
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre prénom")
     * @Assert\Length(min=2)
     */
    private $firstname;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre nom")
     * @Assert\Length(min=2)
     */
    private $lastname;

    private $isAdmin;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre email")
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre mot de passe ")
     * @Assert\Length(min=8)
     */
    private $password;
    
    private $createdAt;

    private $updatedAt;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }

    /**
     * Filling out a new user object with data
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {

            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                switch ($key) {
                    case 'id':
                        $this->$method((int) $value);
                        break;
                    case 'isAdmin':
                        $this->$method((boolean) $value);
                        break;

                    case 'firstname':
                    case 'lastname':
                    case 'email':
                    case 'password':
                        $this->$method((string) $value);
                        break;
                     
                    case 'createdAt':
                    case 'updtedAt':    
                        $this->$method(new \DateTime($value));
                        break;
                }
            }
        }
    }

    /**
     * Get value of user id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set value of user id
     */
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}