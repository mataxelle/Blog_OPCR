<?php

namespace App\Entity;

class Contact
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $message;
    
    /**
     * @var \datetime
     */
    private $createdAt;

    /**
     * @var boolean
     */
    private $isAnswered;

    /**
     * @var \datetime
     */
    private $answeredAt;


    public function __construct(array $data = [])
    {
        $this->hydrate($data);
        
        // end __construct()

    }
    

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method)) {
                switch ($key) {
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
                    case 'isAswered':
                        $this->$method((boolean) $value);
                        break;
                    case 'createdAt':
                    case 'answeredAt':
                        $this->$method(new \DateTime($value));
                        break;
                }
            }
            // end foreach
        }

    }


    /**
     * Get value of contact id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set value of contact id
     */
    public function setId($id)
    {
        if (is_string($id) && (int)$id > 0) {
            $this->id = (int) $id;
        }

        if (is_int($id) && $id > 0) {
            $this->id = $id;
        }
    }

    /**
     * Get value of contact firstname
     *
     * @return string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Set value of contact firstname
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get value of contact lastname
     *
     * @return string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Set value of contact lastname
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get value of contact email
     *
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set value of contact email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get value of contact label
     *
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Set value of contact label
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get value of contact message
     *
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Set value of contact message
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get value of contact creation date
     *
     * @return \Datetime
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set value of contact creation date
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get value of contact is answered
     *
     * @return boolean
     */
    public function getIsAnswered(): ?bool
    {
        return $this->isAnswered;
    }

    /**
     * Set value of contact is answered
     */
    public function setIsAnswered(bool $isAnswered): self
    {
        $this->isAnswered = $isAnswered;
        return $this;
    }

    /**
     * Get value of contact answered at
     *
     * @return \Datetime
     */
    public function getAnsweredAt(): ?\DateTimeInterface
    {
        return $this->answeredAt;
    }

    /**
     * Set value of contact answered at
     */
    public function setAnsweredAt(\DateTimeInterface $answeredAt): self
    {
        $this->answeredAt = $answeredAt;
        return $this;
    }

}
