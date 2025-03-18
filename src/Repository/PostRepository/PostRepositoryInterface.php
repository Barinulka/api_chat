<?php 
namespace App\Repository\PostRepository;

use App\Entity\UUID;
use App\Entity\Post\Post;

interface PostRepositoryInterface
{
    public function save(Post $post): void;

    public function get(UUID $uuid): Post;

    public function delete(UUID $uuid): void;
}