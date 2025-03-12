<?php 
namespace App\Entity\Post;

use App\Entity\User\User;
use App\Entity\UUID;

class Post
{
    public function __construct(
        public UUID $id,
        public User $user,
        public string $title,
        public string $content,
    ) {
    }

    public function __toString()
    {
        return sprintf('%s пишет: %s', $this->user, $this->getContent());
    }

    public function getId(): UUID
    {
        return $this->id;
    }

    public function setId(UUID $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}