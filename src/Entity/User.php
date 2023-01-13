<?php

namespace App\Entity;

class User
{

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var boolean
     */
    private $isAdmin;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \datetime
     */
    private $createdAt;

    /**
     * @var \datetime
     */
    private $updatedAt;


    /**
     * Constructor
     *
     * @param array $data Comment
     * @return void
     */
    public function __construct(array $data= [])
    {
        $this->hydrate($data);

        // End __construct().
    }


    /**
     * Filling out a new user object with data
     *
     * @param array $data
     * @return void
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);

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
            
            // End if.
        }
        // End foreach.
    }


    /**
     * Get value of user id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->userId;

    }



    /**
     * Set value of user id
     *
     * @param mixed $userId The set id
     * @return void
     */
    public function setId($userId)
    {
        if (is_string($userId) && (int) $userId > 0) {
            $this->userId = (int) $userId;
        }

        if (is_int($userId) && $userId > 0) {
            $this->userId = $userId;
        }
    }
    

    /**
     * Get value of user firstname
     *
     * @return string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Set value of user firstname
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get value of user lastname
     *
     * @return string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Set value of user lastname
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get value of user email
     *
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set value of user email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get value of user password
     *
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set value of user password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get value of user is admin
     *
     * @return boolean
     */
    public function isAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    /**
     * Set value of user is admin
     */
    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    /**
     * Get value of user creation date
     *
     * @return \Datetime
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set value of user creation date
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get value of user update date
     *
     * @return \Datetime
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set value of user update date
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
