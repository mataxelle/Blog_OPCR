<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Comment
{
    private $id;

    private $postId;

    private $userId;

    /**
    * @Assert\NotBlank
    */
    private $content;

    private $isValid;

    private $createdAt;

    private $updatedAt;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            switch ($key)
                {
                    case 'id':
                    case 'PostId':
                    case 'userId':
                    case 'isValid':
                        $this->$key = (int) $value;
                        break;

                    case 'content':
                        $this->$key = (string) $value;
                        break;
                     
                    case 'createdAt':
                    case 'updtedAt':    
                        $this->$key = new \DateTime($value);
                        break;
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

    public function getPostId(): ?int
    {
        return $this->postId;
    }

    public function setPostId(int $postId): self
    {
        $this->postId = $postId;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;
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