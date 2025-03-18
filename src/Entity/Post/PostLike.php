<?php 
namespace App\Entity\Post;

use App\Entity\User\User;
use App\Entity\UUID;

class PostLike
{
    public function __construct(
        private UUID $uuid,
        private User $author,
        private Post $post
    ) {

    }

    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    public function setUuid(UUID $uuid): self
    {
        $this->uuid = $uuid;

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

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthorUuid(User $author): self
    {
        $this->author = $author;

        return $this;
    }

}