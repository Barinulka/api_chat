<?php 
namespace App\Repository\CommentRepository;

use App\Entity\UUID;
use App\Entity\Comment\Comment;

interface CommentRepositoryInterface
{
    public function save(Comment $comment): void;

    public function get(UUID $uuid): Comment;
}