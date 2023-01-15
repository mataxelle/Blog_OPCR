<?php

namespace App\Entity;

class Post
{

    /**
     * @var integer $postId
     */
    private $postId;

    /**
     * @var integer $userId
     */
    private $userId;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var string $slug
     */
    private $slug;

    /**
     * @var string $image
     */
    private $image;

    /**
     * @var string $content
     */
    private $content;

    /**
     * @var boolean $isPublished
     */
    private $isPublished;

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
    public function __construct(array $data = [])
    {
        $this->hydrate($data);

        // End __construct().
    }


    /**
     * Filling out a new post object with data
     *
     * @param array $data Data
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
     * Filling out a new post object with data
     *
     * @param array $data Data array
     * @return void
     * @throws \Exception
     */
    /*public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->hydrateData($key, $value);
            // End foreach.
        }

    }*/

    /**
     * Hydrate one data
     *
     * @param string $key   Data key
     * @param string $value Data value
     * @return void
     * @throws \Exception
     */
    /*public function hydrateData(string $key, string $value): void
    {
        $method = 'set'.ucfirst($key);

        if (method_exists($this, $method) === false) {
           return;
        }

        $this->process($method, $key, $value);
    }*/

    /**
     * Process
     *
     * @param string $method The method
     * @param string $key    The key
     * @param string $value  The value
     * @return void
     * @throws \Exception
     */
    /*public function process(string $method, string $key, string $value): void
    {
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
    }*/


    /**
     * Get value of post id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->postId;

    }


    /**
     * Set value of post id
     *
     * @param mixed $postId The set id
     * @return void
     */
    public function setId($postId)
    {
        if (is_string($postId) && (int) $postId > 0) {
            $this->postId = (int) $postId;
        }

        if (is_int($postId) && $postId > 0) {
            $this->postId = $postId;
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
    public function isPublished(): ?bool
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
