<?php
namespace App\Entity\Comment;

use App\Entity\UUID;
use App\Entity\Post\Post;
use App\Entity\User\User;

class Comment
{
    public function __construct(
        public UUID $id,
        public User $user,
        public Post $post,
        public string $comment,
    ) {

    }

    public function __tostring(): string
    {
        return sprintf('%s оставил комментарий: %s', $this->user, $this->comment);
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

    public function getPost(): Post
    {
        return $this->post;
    }

    public function setPost(Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}