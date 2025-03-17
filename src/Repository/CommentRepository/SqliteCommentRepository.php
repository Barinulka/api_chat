<?php 
namespace App\Repository\CommentRepository;

use PDO;
use App\Entity\UUID;
use App\Entity\Comment\Comment;
use App\Repository\PostRepository\PostRepositoryInterface;
use App\Repository\UserRepository\UserRepositoryInterface;
use App\Exception\CommentException\CommentNoFoundException;
use App\Repository\CommentRepository\CommentRepositoryInterface;

class SqliteCommentRepository implements CommentRepositoryInterface
{

    public function __construct(
        private PDO $connection,
        private UserRepositoryInterface $userRepository,
        private PostRepositoryInterface $postRepository
    ) {
    }

    public function save(Comment $comment): void
    {
        $statement = $this->connection->prepare(
            "INSERT INTO comment (uuid, author_uuid, post_uuid, comment) 
            VALUES (:uuid, :author_uuid, :post_uuid, :comment)"
        );

        $statement->execute([
            ":uuid" => $comment->getId(),
            ":author_uuid" => $comment->getUser()->getId(),
            ":post_uuid" => $comment->getPost()->getId(),
            ":comment" => $comment->getComment()
        ]);
    }   
    
    public function get(UUID $uuid): Comment
    {
        $statement = $this->connection->prepare(
            "SELECT * FROM comment WHERE uuid = :uuid"
        );

        $statement->execute([
            ":uuid" => (string) $uuid
        ]);


        return $this->getComment($statement, (string) $uuid);
    }

    private function getComment(\PDOStatement $statement, string $stringUUID): Comment
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            throw new CommentNoFoundException("Комментарий не найден");
        }

        $user = $this->userRepository->get(new UUID($result['author_uuid']));
        $post = $this->postRepository->get(new UUID($result['post_uuid']));

        return new Comment(
            new UUID($result['uuid']),
            $user,
            $post,
            $result['comment'],
        );
    }
}
