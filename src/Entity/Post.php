<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Post
{
    private $id;

    private $userId;

    /**
    * @Assert\NotBlank
    */
    private $title;

    /**
    * @Assert\NotBlank
    */
    private $slug;

    private $image;

    /**
    * @Assert\NotBlank
    */
    private $content;

    private $isPublished;

    private $createdAt;

    private $updatedAt;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data)
    {
        // Boucle sur tableau de données
        foreach ($data as $key => $value) {
            switch ($key)
                {
                    case 'id':
                    case 'userId':
                    case 'isPublished':    
                        $this->$key = (int) $value;
                        break;

                    case 'title':
                    case 'slug':
                    case 'image':
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

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image = null): self
    {
        $this->image = $image;
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

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;
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