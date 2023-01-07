<?php

namespace App\Entity;

class Post
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $content;

    /**
     * @var boolean
     */
    private $isPublished;

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
    public function __construct(array $data = [])
    {
        $this->hydrate($data);

        // End __construct().
    }


    /**
     * Filling out a new post object with data
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
                    case 'userId':
                        $this->$method((int) $value);
                        break;
                    case 'isPublished':
                        $this->$method((boolean) $value);
                        break;
                    case 'title':
                    case 'slug':
                    case 'image':
                    case 'content':
                        $this->$method((string) $value);
                        break;
                    case 'createdAt':
                    case 'updtedAt':
                        $this->$method(new \DateTime($value));
                        break;
                }
                // End switch.
            }

            // End foreach.
        }

    }


    /**
     * Get value of post id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;

    }


    /**
     * Set value of post id
     * 
     * @param mixed $id The set id
     * @return void
     */
    public function setId($id)
    {
        if (is_string($id) && (int) $id > 0) {
            $this->id = (int) $id;
        }

        if (is_int($id) && $id > 0) {
            $this->id = $id;
        }
    }
    

    /**
     * Get value of post user id
     *
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * Set value of post user id
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get value of post title
     *
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set value of post title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get value of post slug
     *
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set value of post slug
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get value of post image
     *
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Set value of post image
     */
    public function setImage(string $image= null): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Get value of post content
     *
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set value of post content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get value of post is published
     *
     * @return boolean
     */
    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    /**
     * Set value of post is published
     */
    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;
        return $this;
    }

    /**
     * Get value of post creation date
     *
     * @return \Datetime
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set value of post creation date
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get value of post update date
     *
     * @return \Datetime
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set value of post update date
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
