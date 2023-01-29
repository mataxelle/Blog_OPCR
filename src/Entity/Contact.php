<?php

namespace App\Entity;

class Contact
{

    /**
     * @var integer $contactId
     */
    private $contactId;

    /**
     * @var string $firstname
     */
    private $firstname;

    /**
     * @var string $lastname
     */
    private $lastname;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $label
     */
    private $label;

    /**
     * @var string $message
     */
    private $message;

    /**
     * @var \datetime $createdAt
     */
    private $createdAt;

    /**
     * @var boolean $isAnswered
     */
    private $isAnswered;

    /**
     * @var \datetime $answeredAt
     */
    private $answeredAt;


    /**
     * Constructor
     *
     * @param array $data Comment
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->hydrate($data);
        // End __construct().
    }


    /**
     * Filling out a new contact object with data
     *
     * @param array $data Data
     * @return void
     * @throws \Exception
     */
    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->hydrateData($key, $value);
            // End foreach.
        }
    }

    /**
     * Hydrate one data
     *
     * @param string $key   Data key
     * @param string $value Data value
     * @return void
     * @throws \Exception
     */
    public function hydrateData(string $key, string $value): void
    {
        $method = 'set'.ucfirst($key);

        if (method_exists($this, $method) === false) {
            return;
        }

        $this->process($method, $key, $value);
    }

    /**
     * Process
     *
     * @param string $method The method
     * @param string $key    The key
     * @param string $value  The value
     * @return void
     * @throws \Exception
     */
    public function process(string $method, string $key, string $value): void
    {
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
                $this->$method((bool) $value);
                break;
            case 'createdAt':
            case 'answeredAt':
                $this->$method(new \DateTime($value));
                break;
        }
    }

    /**
     * Get value of contact id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->contactId;
    }


    /**
     * Set value of contact id
     *
     * @param mixed $contactId The set id
     * @return void
     */
    public function setId($contactId)
    {
        if (is_string($contactId) && (int) $contactId > 0) {
            $this->contactId = (int) $contactId;
        }

        if (is_int($contactId) && $contactId > 0) {
            $this->contactId = $contactId;
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
    public function isAnswered(): ?bool
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
