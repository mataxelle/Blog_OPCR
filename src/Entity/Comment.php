<?php

namespace App\Entity;

class Comment
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $postId;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var boolean
     */
    private $isValid;

    /**
     * @var \datetime
     */
    private $createdAt;

    /**
     * @var \datetime
     */
    private $updatedAt;


    public function __construct(array $data= [])
    {
        $this->hydrate($data);

    }


    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method)) {
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
        }
    }
    
    /**
     * Get value of comment id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set value of comment id
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
     * Get value of comment post id
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
     */
    public function getIsValid(): ?bool
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
