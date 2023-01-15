<?php

namespace App\Entity;

class Comment
{

    /**
     * @var integer $commentId
     */
    private $commentId;

    /**
     * @var integer $postId
     */
    private $postId;

    /**
     * @var integer $userId
     */
    private $userId;

    /**
     * @var string $content
     */
    private $content;

    /**
     * @var boolean $isValid
     */
    private $isValid;

    /**
     * @var \datetime $createdAt
     */
    private $createdAt;

    /**
     * @var \datetime $updatedAt
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
     * @throws \Execption
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

        if (method_exists($this, $method)) {
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
            case 'postId':
            case 'userId':
                $this->$method((int) $value);
            case 'isValid':
                $this->$method((boolean) $value);
                break;
            case 'content':
                $this->$method((string) $value);
                break;
            case 'createdAt':
            case 'updtedAt':
                $this->$method(new \DateTime($value));
                break;
            }
    }
    
    /**
     * Get value of comment id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->commentId;

    }


    /**
     * Set value of comment id
     *
     * @param mixed $commentId The set id
     * @return void
     */
    public function setId($commentId)
    {
        if (is_string($commentId) && (int) $commentId > 0) {
            $this->commentId = (int) $commentId;
        }

        if (is_int($commentId) && $commentId > 0) {
            $this->commentId = $commentId;
        }
    }


    /**
     * Get value of comment post id
     *
     * @return int
     */
    public function getPostId(): ?int
    {
        return $this->postId;
    }

    /**
     * Set value of comment post id
     */
    public function setPostId(int $postId): self
    {
        $this->postId = $postId;
        return $this;
    }

    /**
     * Get value of comment user id
     *
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * Set value of comment user id
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get value of comment content
     *
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set value of comment content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get value of comment is valid
     *
     * @return boolean
     */
    public function isValid(): ?bool
    {
        return $this->isValid;
    }

    /**
     * Set value of comment is valid
     */
    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;
        return $this;
    }

    /**
     * Get value of comment creation date
     *
     * @return \Datetime
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set value of comment creation date
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get value of comment update date
     *
     * @return \Datetime
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set value of comment update date
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
