<?php 
namespace App\Repository\PostRepository;

use PDO;
use App\Entity\UUID;
use App\Entity\Post\Post;
use App\Exception\PostException\PostNotFoundException;
use App\Repository\UserRepository\UserRepositoryInterface;

class SqlitePostRepository implements PostRepositoryInterface
{


    public function __construct(
        private PDO $connection,
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function save(Post $post): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO post (uuid, author_uuid, title, content) 
            VALUES (:uuid, :author_uuid, :title, :content)'
        );

        $statement->execute([
            ':uuid' => $post->getId(),
            ':author_uuid' => $post->getUser()->getId(),
            ':title' => $post->getTitle(),
            ':content' => $post->getContent()
        ]);
    }

    public function get(UUID $uuid): Post
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM post WHERE uuid = :uuid'
        );

        $statement->execute([
            ':uuid' => (string) $uuid
        ]);

        return $this->getPost($statement, (string) $uuid);
    }

    public function delete(UUID $uuid): void
    {
        if ($this->isPostExists($uuid)) {
            $statement = $this->connection->prepare(
                'DELETE FROM post WHERE uuid = :uuid'
            );
    
            $statement->execute([
                ':uuid' => (string) $uuid
            ]);
        }
    }

    private function isPostExists(UUID $uuid): bool
    {
        $post = $this->get($uuid);

        if ($post) {
            return true;
        }

        return false;
    }

    private function getPost(\PDOStatement $statement, string $postUUID): Post
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (false === $result) {
            throw new PostNotFoundException('Запись не найдена');
        }

        $user = $this->userRepository->get(new UUID($result['author_uuid']));

        return new Post(
            new UUID($result['uuid']),
            $user,
            $result['title'],
            $result['content']
        );

    }
}